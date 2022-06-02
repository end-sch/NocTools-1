window.onload = function () {

  $(document).on('change', '#selecao', function () {
    var selecao = $(this).val();
    var opcao = $(this).find(":selected").text();
    switch (selecao) {
      case '0':
        $('#formulario').html('');
        $('#resposta').html('');
        alert('Você precisa selecionar uma opção!');
        break;
      case '1':
        formulario1();
        break;
      case '2':
        formulario2();
        break;
      case '3':
        formulario3();
        break;
      case '4':
        formulario4();
        break;
    }
  }
  )
};

function formulario1() {
  $('#formulario').html(`
  <div>
    <label for="pop"><small class="text-muted">Nome do POP</small></label>
    <input type="text" name="pop" class="form-control border-info" v-model="pop">
  </div>
  <div>
    <label for="vlan"><small class="text-muted">C-Vlan</small></label>
    <input type="text" name="vlan" class="form-control border-info" v-model="vlan">
  </div>
  <div>
    <label for="svlan"><small class="text-muted">S-Vlan</small></label>
    <input type="text" name="svlan" class="form-control border-info" v-model="svlan">
  </div>
  <div>
    <label for="iface"><small class="text-muted">Interface</small></label>
    <input type="text" name="iface" class="form-control border-info" v-model="iface">
  </div>
  </br></br>
  `);

  $('#resposta').html(`
    <table class="table table-bordered"><tr><td>
      <h1>BNG-A</h1>
      </br>set interfaces <span class=bg-success><span class=bg-success>{{ iface }}</span></span> unit <span class=bg-success>{{ vlan }}</span> description "<span class=bg-success>{{ pop }}</span>"
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> encapsulation ppp-over-ether
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> vlan-tags inner <span class=bg-success>{{ vlan }}</span> outer <span class=bg-success>{{ svlan }}</span>
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options access-concentrator BNG-A.csl
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options duplicate-protection
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options dynamic-profile pppoe-profile

      </br></br>
      <h1>BNG-B</h1>
      </br>set interfaces <span class=bg-success><span class=bg-success>{{ iface }}</span></span> unit <span class=bg-success>{{ vlan }}</span> description "<span class=bg-success>{{ pop }}</span>"
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> encapsulation ppp-over-ether
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> vlan-tags inner <span class=bg-success>{{ vlan }}</span> outer <span class=bg-success>{{ svlan }}</span>
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options access-concentrator BNG-B.csl
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options duplicate-protection
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options dynamic-profile pppoe-profile
    </td></tr></table>
    `);

  myObject = new Vue({
    el: '#app',
    data: {
      pop: 'POP (Ex: CSL - POP XXX)',
      vlan: 'C-VLAN (Vlan do POP)',
      svlan: 'S-VLAN (Vlan da Ramificação)',
      iface: 'et-0/0/0',
    }
  });
}

function formulario2() {

  $('#formulario').html(`
  <div>
    <label for="pop"><small class="text-muted">Nome do POP</small></label>
    <input type="text" name="pop" class="form-control border-info" v-model="pop">
  </div>
  <div>
    <label for="vlan"><small class="text-muted">Vlan</small></label>
    <input type="text" name="vlan" class="form-control border-info" v-model="vlan">
  </div>
  <div>
    <label for="iface"><small class="text-muted">Interface</small></label>
    <input type="text" name="iface" class="form-control border-info" v-model="iface">
  </div>
  </br></br>
  `);

  $('#resposta').html(`
    <table class="table table-bordered"><tr><td>
      <h1>BNG-A</h1>
      </br>set interfaces <span class=bg-success><span class=bg-success>{{ iface }}</span></span> unit <span class=bg-success>{{ vlan }}</span> description "<span class=bg-success>{{ pop }}</span>"
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> encapsulation ppp-over-ether
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> vlan-id <span class=bg-success>{{ vlan }}</span>
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options access-concentrator BNG-A.csl
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options duplicate-protection
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options dynamic-profile pppoe-profile

      </br></br>
      <h1>BNG-B</h1>
      </br>set interfaces <span class=bg-success><span class=bg-success>{{ iface }}</span></span> unit <span class=bg-success>{{ vlan }}</span> description "<span class=bg-success>{{ pop }}</span>"
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> encapsulation ppp-over-ether
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> vlan-id <span class=bg-success>{{ vlan }}</span>
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options access-concentrator BNG-B.csl
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options duplicate-protection
      </br>set interfaces <span class=bg-success>{{ iface }}</span> unit <span class=bg-success>{{ vlan }}</span> pppoe-underlying-options dynamic-profile pppoe-profile
    </td></tr></table>
    `);

  myObject = new Vue({
    el: '#app',
    data: {
      pop: 'POP (Ex: CSL - POP Bitcom)',
      vlan: 'VLAN (Vlan do POP)',
      svlan: 'S-VLAN (Vlan da Ramificação)',
      iface: 'et-0/0/0',
    }
  });
}


function formulario3() {

  $('#formulario').html(`
  <div>
    <label for="pon"><small class="text-muted">PON</small></label>
    <input type="text" name="pon" class="form-control border-info" v-model="pon">
  </div>
  <div>
    <label for="onu"><small class="text-muted">ONU</small></label>
    <input type="text" name="onu" class="form-control border-info" v-model="onu">
  </div>
  <div>
    <label for="sn"><small class="text-muted">Serial</small></label>
    <input type="text" name="sn" class="form-control border-info" v-model="sn">
  </div>
  <div>
    <label for="desc"><small class="text-muted">Descrição</small></label>
    <input type="text" name="desc" class="form-control border-info" v-model="desc">
  </div>
  </br></br>
  `);

  $('#resposta').html(`
    <table class="table table-bordered"><tr><td>
      <h5>Comandos iniciais:</h5>
      </br>show gpon onu uncfg
      </br>show gpon onu state gpon-olt_1/<span class=bg-success>{{ pon }}</span>
      </br></br>

      <h5>Aplicar na OLT:</h5>
      </br>interface gpon-olt_1/<span class=bg-success>{{ pon }}</span>
      </br>onu <span class=bg-success>{{ onu }}</span> type BRIDGE sn <span class=bg-success>{{ sn }}</span>
      </br>onu <span class=bg-success>{{ onu }}</span> profile line GERAL remote GERAL
      </br>exit
      </br>interface gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>description "<span class=bg-success>{{ desc }}</span>"
      </br>service-port 1 vport 1 user-vlan 99 vlan 99
      </br>service-port 2 vport 2 user-vlan 4080 vlan 4080
      </br>exit
      </br></br>

      <h5>Comandos de verificação:</h5>
      </br>show running-config interface gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show onu running config gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show gpon onu detail-info gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show pon power olt-rx gpon-olt_1/<span class=bg-success>{{ pon }}</span>
      </br>show pon power attenuation gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show gpon onu by sn <span class=bg-success>{{ sn }}</span>
      </br>show gpon onu detail-info gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show gpon onu distance gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
      </br>show mac gpon onu gpon-onu_1/<span class=bg-success>{{ pon }}</span>:<span class=bg-success>{{ onu }}</span>
    </td></tr></table>
    `);

  myObject = new Vue({
    el: '#app',
    data: {
      pon: '0/0',
      onu: '0',
      sn: 'Serial Number',
      desc: 'Digite uma descrição',
    }
  });
}

function formulario4() {

  $('#formulario').html(`
  <div>
    <label for="vlanpop"><small class="text-muted">Vlan do POP</small></label>
    <input type="text" name="vlanpop" class="form-control border-info" v-model="vlanpop">
  </div>
  <div>
    <label for="nomeolt"><small class="text-muted">Nome da OLT</small></label>
    <input type="text" name="nomeolt" class="form-control border-info" v-model="nomeolt">
  </div>
  <div>
    <label for="ip"><small class="text-muted">IP da OLT</small></label>
    <input type="text" name="ip" class="form-control border-info" v-model="ip">
  </div>
  <div>
    <label for="masc"><small class="text-muted">Máscara da OLT</small></label>
    <input type="text" name="masc" class="form-control border-info" v-model="masc">
  </div>
  <div>
    <label for="gw"><small class="text-muted">Gateway da OLT</small></label>
    <input type="text" name="gw" class="form-control border-info" v-model="gw">
  </div>
  </br></br>
  `);

  $('#resposta').html(`
    <table class="table table-bordered"><tr><td>
    </br>enable
    </br>configure terminal
    </br>![VLAN]
    </br>interface range ethernet 0/3 to ethernet 0/7
    </br>switchport mode access
    </br>exit
    </br>interface range ethernet 0/1 to ethernet 0/2 ethernet 1/1 to ethernet 1/4
    </br>switchport mode trunk
    </br>exit
    </br>interface range pon 0/1 to pon 0/4
    </br>switchport mode trunk
    </br>exit
    </br>vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>vlan 4080
    </br>description VoIP
    </br>exit
    </br>![DEVICE]
    </br>interface ethernet 0/1
    </br>switchport trunk allowed vlan <span class=bg-success>{{ vlanpop }}</span>,4080
    </br>exit
    </br>interface ethernet 0/2
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface ethernet 0/3
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>interface ethernet 0/4
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>interface ethernet 0/5
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>interface ethernet 0/6
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>interface ethernet 0/7
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>exit
    </br>interface pon 0/1
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface pon 0/2
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface pon 0/3
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface pon 0/4
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface ethernet 1/1
    </br>switchport trunk allowed vlan <span class=bg-success>{{ vlanpop }}</span>,4080
    </br>exit
    </br>interface ethernet 1/2
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface ethernet 1/3
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>interface ethernet 1/4
    </br>switchport default vlan <span class=bg-success>{{ vlanpop }}</span>
    </br>switchport trunk allowed vlan 1,4080
    </br>exit
    </br>![OAM]
    </br>username admin privilege 15 password 0 N0h4ck3r
    </br>y
    </br>hostname <span class=bg-success>{{ nomeolt }}</span>
    </br>!
    </br>clock timezone brasilia -3
    </br>!
    </br>![SNMP]
    </br>snmp-server name <span class=bg-success>{{ nomeolt }}</span>
    </br>snmp-server community bitsnmp ro permit view iso
    </br>![IF]
    </br>interface vlan-interface <span class=bg-success>{{ vlanpop }}</span>
    </br>ip address <span class=bg-success>{{ ip }}</span> <span class=bg-success>{{ masc }}</span>
    </br>exit
    </br>![STATIC_ROUTE]
    </br>ip route 0.0.0.0 0.0.0.0 <span class=bg-success>{{ gw }}</span>
    </br>!
    </br>![SNTPC]
	</br>sntp client
	</br>sntp client mode unicast
	</br>sntp server 187.63.191.4
    </br>!
    </br>exit
    </br>copy running-config startup-config
    </br>y
    </td></tr></table>
    `);

  myObject = new Vue({
    el: '#app',
    data: {
      vlanpop: 'Digite a vlan do POP',
      nomeolt: 'Digite o nome da OLT',
      ip: 'Digite o IP da OLT (Ex: 192.168.1.2)',
      masc: 'Digite a máscara da OLT (Ex: 255.255.255.240)',
      gw: 'Digite o gateway da OLT (Ex: 192.168.1.1)',
    }
  });
}