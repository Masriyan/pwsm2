var event;

function isJsEnabled() {
  if (typeof document.jsEnabled == 'undefined') {
    // Note: ! casts to boolean implicitly.
    document.jsEnabled = !(
     !document.getElementsByTagName ||
     !document.createElement        ||
     !document.createTextNode       ||
     !document.documentElement      ||
     !document.getElementById);
  }
  return document.jsEnabled;
}

// Global Killswitch on the <html> element
if (isJsEnabled()) {
  document.documentElement.className = 'js';
}

/**
 * Make IE's XMLHTTP object accessible through XMLHttpRequest()
 */
if (typeof XMLHttpRequest == 'undefined') {
  XMLHttpRequest = function () {
    var msxmls = ['MSXML3', 'MSXML2', 'Microsoft']
    for (var i=0; i < msxmls.length; i++) {
      try {
        return new ActiveXObject(msxmls[i]+'.XMLHTTP')
      }
      catch (e) { }
    }
    throw new Error("No XML component installed!");
  }
}
function confirm_form(url,text)
{
	if(confirm(text))
	document.location=url;
	else return false;
}

function getAttributes(node)  
{  
  var ret = new Object();  
  if(node.attributes)  
  for(var i=0; i<node.attributes.length; i++)  
  {  
    var attr = node.attributes[i];  
    ret[attr.name] = attr.value;  
  }  
  return ret;  
}  
function chk_pattern_form()
{
if(document.pattern_form.op.value=='cancel'){return true;}
   if(document.pattern_form.code.value.trim().length==0){document.pattern_form.code.focus();alert("Code of pattern cannot be empty!");return false;}
   return true;
}
var RNF={};
RNF.init=function (){
    RNF.init_update_btn();
};
RNF.init_update_btn=function (){
    $('.update_btn').click(function (){
        if($('#password1').val().length<6)
        {   
            $('#password1').val('');
            $('#password2').val('');
            alert('Password to short')
            return false;
        }
        if($('#password1').val()!=$('#password2').val())
        {   
            $('#password1').val('');
            $('#password2').val('');
            alert('Passwords not Equal')
            return false;
        }
       
        $('#pass_chg').submit();
        
    });
}
var UEF={};
UEF.init = function (){
  UEF.reg_pass();  
};
UEF.reg_pass=function (){
    $('#user_edit_btn').click(function (){
      if(UEF.chk_user_edit_form())
      {
          $('#op').val('save');
          $('#user_edit_form').submit();
      }
    });
    $('#user_del_btn').click(function (){
        if(confirm("Sure delete user?"))
        {
        $('#op').val('delete');
        $('#user_edit_form').submit();
        }
    })
};
UEF.chk_user_edit_form=function (){
   

  if($('#email').val().length==0){alert("Please type email of user");$('#email').val('').focus();return false;}
  
  if(($('#password1').val().length==0)&&($('#id').val()==0)){alert("Please type password for new user");$('#password1').focus();return false;}
  if(($('#password1').val()!=$('#password2').val())){alert("passwords typed  for user not equal");$('#password1').val('').focus();$('#password2').val('');return false;}
  return true;
};
var AL={};
AL.init=function(){
  AL.reg_cb_al();  
  AL.init_uninstall();
};
AL.init_uninstall=function (){
  $('.uninstall').click(function (event){
      
      var u=$(event.target);
      if(confirm('Sure uninstall object '+u.attr('object_url')+'?'))
      {
          document.location='?q=uninstall_object&id='+u.attr('object_id');
      }
  });  
};
AL.reg_cb_al=function (){
    $('.cb_al').change(function (){
        var data={};
        data.act='alcb';
        data.type=$(this).attr('cb_type');
        data.id=$(this).attr('cb_id');
        data.value=$(this).is(':checked');
        var parts=[];
        for(d in data)
        {
            parts.push(d+'='+data[d]);
            
        }
        $.ajax('ajax.php?'+parts.join('&')).done(function (http){
            
        });
    });
};
/* Test Form */
var TF={};
TF.init=function(){
  TF.init_send_test_btn();  
  TF.init_more_variables4test();
};
TF.init_more_variables4test=function (){
    $('#more_variables4test').click(TF.more_variables4test);
};
TF.init_send_test_btn=function (){
    $('#send_test_btn').click(TF.send_test_form);
};
TF.send_test_form=function ()
{
    if($('#url').val().length==0)
    {
    $('#url').focus();
    alert("Url of target cannot be empty");
    return false;
    }
    var url=$('#url').val();
    if((url.substr(0,7)!='http://')&&(url.substr(0,8)!='https://'))url='http://'+url;
     var myform=$("<form>").attr("action", url).attr("method", $('#method').val());
 $('#variables li').each(function (i,li){
     if($(li).find('.name').val().length==0)
     {
         $(li).find('.name').focus();
         alert("Variable name cannot be empty");
         return false;
     }
     if($(li).find('.value').val().length==0)
     {
         $(li).find('.value').focus();
         alert("Variable value cannot be empty");
         return false;
     }    
     var inp=$('<input>').attr('type','hidden').attr('name',$(li).find('.name').val()).val($(li).find('.value').val());
     
     myform.append(inp);
 });
 $('body').append(myform);
 myform.submit();
};
TF.more_variables4test=function ()
{
    var li=$('<li>');
    li.append('Custom variable:');
    li.append($('<input>').attr('type','text').addClass('name'));
    li.append('&nbsp;=&nbsp;Value:');
    li.append($('<input>').attr('type','text').addClass('value'));
   $('#variables').append(li);
};
var RS={};
RS.init=function (){
    RS.init_show_info();
    //RS.init_headers_actions();
    RS.init_search_form();
    RS.init_more_btn();
};
RS.init_search_form= function (){
    $('#search_form_btn').click(function (){
        $('#search_form').show();
        $('#search_form_btn').hide();
    });
    $('#from').datepicker({dateFormat:'dd-mm-yy',   
                        maxDate:'today',
                        onClose: function( selectedDate ) {
                        $( "#to" ).datepicker( "option", "minDate", selectedDate );
                        if($( "#to" ).val().length==0)$( "#to" ).val(selectedDate);
                        }});
    $('#to').datepicker({dateFormat:'dd-mm-yy',maxDate:'today'});
    if((RS.ip.length)||(RS.query.length)||(RS.from.length)||(RS.to.length)||(RS.status.length)||(RS.method.length))
    {
        $('#search_form').show();
        $('#search_form_btn').hide();
    }
    $('#search_form_close').click(function (){
        $('#search_form').hide();
        $('#search_form_btn').show();
    });
};
RS.init_show_info=function (){
    
    $('.show_info').tooltip({
              tooltipClass:'preview-tip',    
              content:function(callback) {
                var type=$(this).attr('show_type');
                var id=$(this).attr('show_id');


                $.get('ajax.php?act='+type+'&id='+id, {

                }, function(data) {
                    callback(data); 
                });
            }
    });
};
RS.init_more_btn=function (){
  $('#more_btn').click(function (){
      var id=$('#more_btn').attr('rel');
      var url='ajax.php?act=request_more_info&id=' + id + '&result_num=' + RS.result_num;
      if(RS.ip.length)url+='&ip='+RS.ip;
      if(RS.query.length)url+='&query='+RS.query;
      if(RS.from.length)url+='&from='+RS.from;
      if(RS.to.length)url+='&to='+RS.to;
      if(RS.status.length)url+='&status='+RS.status;
      if(RS.method.length)url+='&method='+RS.method;
    $.ajax(url)
            .done(function (http){
                $('#request_tbl_box').append($('<div>').addClass('request_tbl_div').html(http));
                RS.result_num+=RS.results_step;

                if(RS.result_num>RS.results_count)$('#more_btn').hide();
                
            });
  });  
};
/*
RS.init_headers_actions=function (){
  $('#chg_status').click(function (event){
      RS.show_info(event,'chg_status',RS.chg_status);
  });
  $('#chg_url').click(function (event){
      RS.show_info(event,'chg_url',RS.sortby);
  });
  $('#chg_query_string').click(function (event){
      RS.show_info(event,'chg_query_string',RS.sortby);
  });
    $('#chg_method').click(function (event){
      RS.show_info(event,'chg_method',RS.chg_method);
  });
  $('#chg_remote_ip').click(function (event){
      RS.show_info(event,'chg_remote_ip',RS.sortby);
  });
  $('#chg_date').click(function (event){
      RS.show_info(event,'chg_date',RS.sortby);
  });
};*/
RS.show_info=function (e,type,id)
{
    if($('#info').html()==null)
    {
    $.ajax('ajax.php?act='+type+'&id='+id).done(function (http){
       // $(e.target).attr('title',http).addClass('tooltip').tooltip();

        var box=$('<div>').html(http).attr("id","info");
       if (e== undefined)
       {

          // IE case
          var d= (document.documentElement &&
          document.documentElement.scrollLeft != null) ?
          document.documentElement : document.body;

         docX= x + d.scrollLeft;
         docY= y + d.scrollTop;
       }
       else
       {

          // all other browsers
          docX= e.pageX;
          docY= e.pageY;

       }
        box.css({'position':'absolute','left':docX,'top':(docY+2)});
       $('body').append(box);
    });

    }
};
RS.hide_info=function ()
{
$("#info").remove();
};
