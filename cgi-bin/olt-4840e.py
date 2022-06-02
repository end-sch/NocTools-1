#!/usr/bin/env python3.9
import telnetlib
import re

###Inicio HTML Header################################################
import cgi, cgitb
cgitb.enable()
print("Content-Type: text/html; charset=utf-8")
print()
###Fim do HTML Header################################################

form = cgi.FieldStorage()

HOST = form.getvalue("parametro")
USER = "username"
PWD = "password"

try:
	tn = telnetlib.Telnet(HOST, timeout=5)

	tn.read_until(b"Username(1-32 chars):", timeout=2)
	tn.write(USER.encode('utf-8') + b"\n")
	if PWD:
	    tn.read_until(b"Password(1-16 chars):", timeout=2)
		tn.write(PWD.encode('utf-8') + b"\n")		
except:
	print("Nao foi possivel se conectar ao equipamento.")
	exit()

def lista_onu():
	tn.write(b"show onu-status\n")
	output = (tn.read_until(b"####", 3).decode('utf-8')).splitlines()
	onus_offline = []
	onus_online = []
	for line in output:
		line = re.split(' +', line)
		if 'Down' in line:
			onus_offline.append(line)
		if 'Up' in line:
			if len(line) < 8:
				line.insert(6, '-')
			line += dicionario(line[6])
			onus_online.append(line)
	if len(onus_offline) == 0:
		print(tabela([['Nenhuma ONU Offline encontrada no momento.']], 'Lista de ONUs Offline:'))
	else:
		print(tabela(onus_offline, 'Lista de ONUs Offline que foram excluídas:'))
		deleta_onu_offline(onus_offline)
	print(tabela(agrupa_onus(onus_online), 'Onus agrupadas por versão:'))
	print(tabela(contabiliza_onus(onus_online), 'Total de ONUs por PON:'))
	print(tabela(onus_online, 'Lista de ONUs Online:'))


def deleta_onu_offline(onus_offline):
	for line in onus_offline:
		tn.write("no onu-binding onu ".encode('utf-8') + line[0].encode('utf-8') + b"\n y \n")
		tn.read_until(b"####", 1)


def contabiliza_onus(onus_online):
	p1, p2, p3, p4 = 0, 0, 0, 0
	for line in onus_online:
		line = line[0]
		if "/1/" in line:
			p1 = p1 + 1
		elif "/2/" in line:
			p2 = p2 + 1
		elif "/3/" in line:
			p3 = p3 + 1
		elif "/4/" in line:
			p4 = p4 + 1
	return [['PON 1:',str(p1),'PON 2:',str(p2),'PON 3:',str(p3),'PON 4:',str(p4)]]

def agrupa_onus(onus_online):
	agrupa_versao = {}
	agrupamento = []
	for line in onus_online:
		versao = line[6]
		if versao in agrupa_versao:
			agrupa_versao[versao] = agrupa_versao[versao] + 1
		else:
			agrupa_versao[versao] = 1
	for versao in agrupa_versao:
		agrupamento.append([versao, str(agrupa_versao.get(versao))] + dicionario(versao))
	return sorted(agrupamento, key=lambda i: i[2])

def dicionario(s):
	if re.search(r'^OT4020VW.*\.', s):
		return ['Overtek OT-4020vw','Overtek']
	elif re.search(r'^OTE801G.*\.', s):
		return ['Overtek OT-801G','Overtek']
	elif re.search(r'^V[0-9]\.[0-9]\.[0-9]', s):
		return ['EB01','Cianet']
	elif re.search(r'02R001', s):
		return ['OT-801F1G','Overtek']
	elif re.search(r'1.0-200522|1.0-191025|1.0-210531', s):
		return ['110B','Intelbras']
	elif re.search(r'^V2([0-9]){5}$|1.0-210917', s):
		return ['Wifiber 121AC','Intelbras']
	elif re.search(r'^1\.[0-9]\-2([0-9]){5}$', s):
		return ['R1','Intelbras']
	elif re.search(r'^1\.0\.[0-9]', s):
		return ['110Gi','Intelbras']
	elif re.search(r'-', s):
		return ['OT-E8010U','Overtek']
	else:
		return ['Não identificado', 'Não identificado']

def tabela(*args):
	thead = f'<thead><tr><td colspan={len(args[0][0])}><center><b>{args[1]}</b></center></td></tr></thead>'
	tbody = ''
	for linha in args[0]:
		tbody += '<tr><td>' + '</td><td>'.join(linha) + '</td></tr>'
	return f'<table class="table table-hover table-dark table-sm">{thead}<tbody>{tbody}<tbody></table></br>'

tn.write(b"enable\nconfigure terminal\n")
lista_onu()

tn.write(b"exit\n copy running-config startup-config\n y\n")
tn.close()
