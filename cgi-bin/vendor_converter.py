#!/usr/bin/env python3.9
import re

###Inicio HTML Header################################################
import cgi;
print("Content-Type: text/html; charset=utf-8")
print()
###Fim do HTML Header################################################

form = cgi.FieldStorage()
#print(form)

variavel = form.getvalue("variavel").splitlines()
#print(variavel)


""" converte Parks para ZTE
pon = '1/8'
i = 0

for linha in variavel:
	if 'alias' in linha:
		i += 1
		lista_onu = linha.split(' ')
		print(f'''interface gpon-olt_1/{pon}</br>
		onu {i} type BRIDGE sn {lista_onu[2].upper()}</br>
		onu {i} profile line GERAL remote GERAL</br>
		exit</br>
		interface gpon-onu_1/{pon}:{i}</br>
		description "{lista_onu[4]}"</br>
		service-port 1 vport 1 user-vlan 3486 vlan 3486</br>
		service-port 2 vport 2 user-vlan 4080 vlan 4080</br>
		exit</br></br>''')
	
"""

""" Converte Huawei pra ZTE


lista_sn = []
lista_desc = []


for linha in variavel[::2]:
	linha = linha.split('"')
	linha[1] = linha[1].replace('48575443', 'HWTC')
	lista_sn.append(linha[1])

for linha in variavel[1::2]:
	linha = linha.split('"')
	lista_desc.append(linha[1])

#print(lista_sn, lista_desc)

i = 0
pon = '1/15'

while i <= len(lista_sn):
	print(f'''interface gpon-olt_1/{pon}</br>
	onu {i+1} type BRIDGE sn {lista_sn[i]}</br>
	onu {i+1} profile line GERAL remote GERAL</br>
	exit</br>
	interface gpon-onu_1/{pon}:{i+1}</br>
	description "{lista_desc[i]}"</br>
	service-port 1 vport 1 user-vlan 3486 vlan 3486</br>
	service-port 2 vport 2 user-vlan 4080 vlan 4080</br>
	exit</br></br>''')

	i += 1

"""