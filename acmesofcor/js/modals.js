function myFunction(event) { 
    var x = event.target;
    //alert(img+" ID = "+ x.src);
    $('.modal-body img').attr('src',x.src);
    $('#centralModalSm').modal();
  }