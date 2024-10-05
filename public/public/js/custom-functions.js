$(document).ready(function() {
    if($('.permission:checked').length == $('.permission').length){
            $('#selecctall').prop('checked',true);
        }else{
            $('#selecctall').prop('checked',false);
        }
    $('#selecctall').click(function(event) {
        if(this.checked) { // check select status
            $('.permission').each(function() {
                this.checked = true;  //select all
            });
        }else{
            $('.permission').each(function() {
                this.checked = false; //deselect all            
            });        
        }
    });

    $('.permission').on('click',function(){

        if($('.permission:checked').length == $('.permission').length){
            $('#selecctall').prop('checked',true);
        }else{
            $('#selecctall').prop('checked',false);
        }
    });
  
});

function printDiv(printDiv){
 //Get the HTML of div
    var divElements = document.getElementById(printDiv).innerHTML;
    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the page's HTML with div's HTML only
    document.body.innerHTML = 
      "<html><head><title></title></head><body>" + 
      divElements + "</body>";

    //Print Page
    window.print();
   
    //Restore orignal HTML
    document.body.innerHTML = oldPage;
            
}
