function mostra_menu(element,event){
el=document.getElementById(element);

if (el.style.display=='none'){

	if(document.selection)
		el.style.display='';
	else
		el.style.display='inline';

	el.style.top=event.offsetY;
	el.style.left=event.offsetX;

}else{

	el.style.display='none';

}

}

function insereTag (element,tag) {
el=document.getElementById(element);


if(document.selection){//IE

if (tag =='b' || tag =='i' || tag =='u')
		var newText='['+tag+'][/'+tag+']';
	else
		var newText=" "+tag+" ";

	el.value+=newText;

}else{//FF

	var selectedText=document.selection?document.selection.createRange().text:el.value.substring(el.selectionStart,el.selectionEnd);// IE:Moz

	if (tag =='b' || tag =='i' || tag =='u')
		var newText='['+tag+']'+selectedText+'[/'+tag+']';
	else
		var newText=" "+tag+" ";

	el.value=el.value.substring(0,el.selectionStart)+newText+el.value.substring(el.selectionEnd,el.value.length);

}

}

function flash(file, width, height){
    document.write("<object  classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='" + width + "' height='" + height + "'>");
    document.write("<param name='movie' value='" + file + "'>");
    document.write("<param name='quality' value='high'>");
	document.write("<param name='wmode' value='transparent' />");
    document.write("<embed  src='" + file + "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='" + width + "' height='" + height + "' wmode='transparent'></embed>");
    document.write("</object>");
}

function checar_caps_lock(ev) {
	var e = ev || window.event;
	codigo_tecla = e.keyCode?e.keyCode:e.which;
	tecla_shift = e.shiftKey?e.shiftKey:((codigo_tecla == 16)?true:false);
	if(((codigo_tecla >= 65 && codigo_tecla <= 90) && !tecla_shift) || ((codigo_tecla >= 97 && codigo_tecla <= 122) && tecla_shift)) {
		document.getElementById('aviso_caps_lock').style.display = 'block';
	}
	else {
		document.getElementById('aviso_caps_lock').style.display = 'none';
	}
}


function abreDiv(valor,retorna){
	divFundo=document.getElementById('fundoPreto');
	divAviso=document.getElementById('div_aviso');

	divFundo.style.display='block';
	divAviso.style.display='block';

	divAviso.style.top='40%';
	divAviso.style.left='35%';
	divAviso.style.width='350px';
	divAviso.style.height='50px';

	abreArquivoAjax('ajax/usuario/mostra_rs.php?valor='+valor,'div_aviso',retorna,true)
}

function fechaAviso(){
	divFundo=document.getElementById('fundoPreto');
	divAviso=document.getElementById('div_aviso');
	divFundo.style.display='none';
	divAviso.style.display='none';
}

function abreFecha(id){

if (document.getElementById(id).style.display=='')
	document.getElementById(id).style.display='none';
else
	document.getElementById(id).style.display='';
}

function abre(id){
	document.getElementById(id).style.display='block';
}

function fecha(id){
	document.getElementById(id).style.display='none';
}

function abre2(id){
	document.getElementById(id).style.display='';
}


function alternaClasse(id,classe1,classe2){
if (document.getElementById(id).className==classe1)
	document.getElementById(id).className=classe2;
else
	document.getElementById(id).className=classe1;
}

function select(theField) {
var tempval=eval("document."+theField);
tempval.focus();
tempval.select();
}

function abreSubTab(flag){

	for (i=1;i<=12;i++){
		fecha("subtab"+i);
		document.getElementById("itemtab"+i).className="";
	}

	abre("subtab"+flag);
	document.getElementById("itemtab"+flag).className="current";

}

/////

function abrirTermos(tipo,retorna){
	window.open(retorna+'termos?tipo='+tipo, '', "status=no, width=600, height=500, scrollbars=yes");
}


////

function emoticon(smilie,div){
	campo=document.getElementById(div);
	campo.value=campo.value+" "+smilie;
}


/////////

function checa_seguranca(pass, campo){
		var senha = pass;
		var entrada = 0;
		var resultadoado;

		if(senha.length < 9){
				entrada = entrada - 1;
		}

		if(!senha.match(/[a-z_]/i) || !senha.match(/[0-9]/)){
				entrada = entrada - 1;
		}

		if(!senha.match(/\W/)){
				entrada = entrada - 1;
		}

		if(entrada == 0){
				resultado = 'A Segurança de sua senha é: <font color=\'#388000\'><strong>EXCELENTE</strong></font>';
		} else if(entrada == -1){
				resultado = 'A Segurança de sua senha é: <font color=\'#0037FF\'><strong>MÉDIA</strong></font>';
		} else if(entrada == -2){
				resultado = 'A Segurança de sua senha é: <font color=\'#FFB200\'><strong>BAIXA</strong></font>';
		} else if(entrada == -3){
				resultado = 'A Segurança de sua senha é: <font color=\'#FF0000\'><strong>MUITO BAIXA</strong></font>';
		}

		document.getElementById(campo).innerHTML = resultado;

		return;
}
///////////////////
//mascaras
//////////////////

function formatar(src, mask, evtKeyPress){
  var tecla = window.event ? evtKeyPress.keyCode : evtKeyPress.which;

  if (tecla != 8) //só força a escrita da máscara de a tecla pressionada NÃO for o BACKSPACE
  {
    var i = src.value.length;
    var saida = mask.substring(0,1);
    var texto = mask.substring(i)
    if (texto.substring(0,1) != saida)
    {
      src.value += texto.substring(0,1);
    }
  }
}

function sonumeros(e,args){
        if (document.all){var evt=event.keyCode;}
        else{var evt = e.charCode;}
        var valid_chars = '0123456789'+args;
        var chr= String.fromCharCode(evt);
        if (valid_chars.indexOf(chr)>-1 ){return true;}
        if (valid_chars.indexOf(chr)>-1 || evt < 9){return true;}
        return false;
    }

function troca(e,args){
        if (document.all){var evt=event.keyCode;}
        else{var evt = e.charCode;}
        var valid_chars = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'+args;
        var chr= String.fromCharCode(evt);
        if (valid_chars.indexOf(chr)>-1 ){return true;}
        if (valid_chars.indexOf(chr)>-1 || evt < 9){return true;}
        return false;
    }

function troca_onblur(campo){
	campo.value = campo.value.toLowerCase();
	var estranha = "áéíóúàèìòùâêîôûäëïöüãõçý@#$%^&*();._,+=~´` -!%¨[]}{:<>";
	var correta =  "aeiouaeiouaeiouaeiouaocy______________________________";
	var retorno = "";
	for(i=0;i<estranha.length;i++)
	{
		for(j=0;j<campo.value.length;j++)
		{
		retorno = campo.value.replace(estranha.substr(i,1),correta.substr(i,1));
		retorno = retorno.replace("_","");
		campo.value = retorno;
		}
	}
}


function addFav(title,url){

 if (window.sidebar) window.sidebar.addPanel(title, url,"");
 else if(window.opera && window.print){
 var mbm = document.createElement('a');
 mbm.setAttribute('rel','sidebar');
 mbm.setAttribute('href',url);
 mbm.setAttribute('title',title);
 mbm.click();
 }
 else if(document.all){window.external.AddFavorite(url, title);}
}

function valida_busca(){
if ((document.getElementById('q_busca_topo').value == "Pesquisar...") || (document.getElementById('q_busca_topo').value == " ")){
document.getElementById('q_busca_topo').focus();
return false;
}
}

/********************************/

function Get_Cookie( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f

	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}


function Set_Cookie( name, value, expires, path, domain, secure ) {
	// set time, it's in milliseconds
	var today = new Date();
	today.setTime( today.getTime() );
	// if the expires variable is set, make the correct expires time, the
	// current script below will set it for x number of days, to make it
	// for hours, delete * 24, for minutes, delete * 60 * 24
	if ( expires )
	{
		expires = expires * 1000 * 60 * 60 * 24;
	}
	//alert( 'today ' + today.toGMTString() );// this is for testing purpose only
	var expires_date = new Date( today.getTime() + (expires) );
	//alert('expires ' + expires_date.toGMTString());// this is for testing purposes only

	document.cookie = name + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + //expires.toGMTString()
		( ( path ) ? ";path=" + path : "" ) +
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
}

// this deletes the cookie when called
function Delete_Cookie( name, path, domain ) {
	if ( Get_Cookie( name ) ) document.cookie = name + "=" +
			( ( path ) ? ";path=" + path : "") +
			( ( domain ) ? ";domain=" + domain : "" ) +
			";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

// construindo o calendário
function popdate(obj,div,tam,ddd)
{
    if (ddd) 
    {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "/") 
            {
                c++; 
                s++; 
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }
        ddd = mmonth + "/" + day + "/" + ano
    }
  
    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}
  
    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)
  
    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)
 
    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}
    txt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>X</b></a></td></tr></table></td></tr>"
    txt += "<tr><td colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    txt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    txt += "<tr bgcolor='#330099'><td width='14%' class='dia' align=center><b>Dom</b></td><td width='14%' class='dia' align=center><b>Seg</b></td><td width='14%' class='dia' align=center><b>Ter</b></td><td width='14%' class='dia' align=center><b>Qua</b></td><td width='14%' class='dia' align=center><b>Qui</b></td><td width='14%' class='dia' align=center><b>Sex<b></td><td width='14%' class='dia' align=center><b>Sab</b></td></tr>"
    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;
 
    for (n=1;n<= 42;n++) 
    {
        if (week == 1)  txt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start) 
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" )
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  d + "/" + (mmonth+1).toString() + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            d ++ 
        } 
        else 
        { 
            txt += "<td class='data' align=center> </td>"
        }
        week ++
        if (week == 8) 
        { 
            week = 1; txt += "</tr>"} 
        }
        txt += "</table>"
        div2 = eval (div)
        div2.innerHTML = txt 
}
  
// função para exibir a janela com os meses
function pop_month(obj, div, tam, ano)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"')>" + umonth[n] +"</a></td></tr>" }
  txt += "</table>"
  popd.innerHTML = txt
}
 
// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) txt += "<tr>"
     txt += "<td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"')>" + n + "</a></td>"
     l++
     if (l == 4) 
        {txt += "</tr>"; l = 1 } 
  }
  txt += "</tr></table>"
  popd.innerHTML = txt 
}
 
// função para fechar o calendário
function force_close(div) 
    { div2 = eval (div); div2.innerHTML = ''}
    
// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div)
{ 
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data 
}
