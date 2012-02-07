// JavaScript Document
function OnSubmitForm(url)
{ 
   document.form.action = url;
   document.form.submit();
   return true;
}