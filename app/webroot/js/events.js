$(document).ready(function(){

  var currpage = 1;
  var limit = null;
  var tempElement = null;

  $('.select2').select2({
      ajax: {
        url: "retrieve_users",
        dataType: 'json',
        delay: 100,
        processResults: function (res) {
          var temp = [];
          for(var i = 0; i < res.length; i++){
            temp.push({
              id: res[i].User.id,
              text: res[i].User.name,
              img: res[i].User.image
            });            
          }

          return {
              results: temp
          };          
        },
      },
      templateResult: formatState,
      minimumInputLength: 2,
      placeholder: 'Please type a name'
    });

  if(window.location.href.includes('message') && $('#currpage').val() == 'messagelist'){
    limit = $('#limit').val();
    displayMessage(1, limit);
  }  

  if(window.location.href.includes('details')){
    limit = $('#limit').val();
    displayMessageDetails(1, limit, window.location.href);
  }

  $(document).on('click', '.show-more', function(e){
    e.preventDefault();
    currpage += 1;
    displayMessage(currpage, limit);

  });  

  $(document).on('click', '.show-more-details', function(e){
    e.preventDefault();
    currpage += 1;
    displayMessageDetails(currpage, limit, window.location.href);

  });



  if(window.location.href.includes('edit')){
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
      $( "#datepicker" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange: "1990:2019"      
      });
  }

  $(document).on('keyup', '.search', function(){
    var search = $(this).val();
    displayMessage(1, limit, search);
  });  

  $(document).on('click', '.delete', function(){
    var id = $(this).attr('data-id');
    tempElement = $(this);
    $.ajax({
      url: 'messages/delete',
      type: 'POST',
      dataType: 'json',
      data: { id : id },
      success: function(res){
        console.log(res);
        if(res == 'success'){
          tempElement.parents('li').fadeOut( "slow", function() {
            // Animation complete.
          });
        }else{
          alert('Something went wrong!');
        }
        
      }
    })
  });  

  $(document).on('click', '.delete-detail', function(){
    var id = $(this).attr('data-id');
    tempElement = $(this);
    $.ajax({
      url: '/message_board/messages/deleteDetail',
      type: 'POST',
      dataType: 'json',
      data: { id : id },
      success: function(res){
        console.log(res);
        if(res == 'success'){
          tempElement.parents('li').fadeOut( "slow", function() {
            // Animation complete.
          });
        }else{
          alert('Something went wrong!');
        }
        
      }
    })
  });


  $(document).on('submit', '#MessageDetailsForm', function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      url: '/message_board/messages/add',
      type: 'POST',
      dataType: 'json',
      data: formData+'&type=reply',
      success: function(res){
        console.log(res);
        if(res == 'success'){
          displayMessageDetails(1, limit, window.location.href, true);
          $("#MessageDetailsForm")[0].reset(); 
        }else{
          alert('Something went wrong!');
        }
        
      }
    })

  })  

});


function formatState (item) {
  var img = item.img;
  if(img == 'null' || img == null){
    img = 'default-photo.png';
  }
  var $data = $(
    '<span><img src="/message_board/img/'+img+'" class="img-flag" />'+item.text+'</span>'
  );
  return $data;
};


 function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    // for (var i = 0, f; f = files[i]; i++) {
    	var f = files[0];

      // Only process image files.
      if (!f.type.match('image.*')) {
        // continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').innerHTML = span.innerHTML;
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    // }
  }

  function displayMessage(currpage, limit, search = null){

     $.ajax({
        url: "messages/index/page:"+currpage,
        dataType: 'json',
        type: 'POST',
        data: {search: search, currpage : currpage},
        success: function(res){
          var str = '';
          var ctr = 1;
          var content = '';
          var photo = '';
          var created = '';
          var id = '';

          if(res.messages.length == 0){
            str += '<li class="no-data">No message.</lit>';
            $('.show-section').addClass('d-none');
          }else{
            $('.no-data').remove();
          }

          $.each(res.messages, function(key, val){
            if(ctr > limit)
              return;
            content = val.messages.content;
            created = val.messages.msg_date;
            photo = val.users.image;
            
            if(photo == ''){
              photo = 'default-photo.png';
            }

            str += '<li class="nopadding border"><div class="row">';
            str += '<div class="col-md-2 text-center border"> <a href="/message_board/profile/'+val.messages.id+'"><img src="/message_board/img/'+photo+'" class="photo" alt=""></a> </div> <div class="col-md-10"><button data-id="'+val.messages.id+'" class="delete float-right">X</button><a href="/message_board/messages/details/'+val.messages.id+'"><p class="nopadding"><span class="d-block content-span border">'+content+'</span><span class="d-block created-span border">'+created+'</span> </p> </a> </div>';

            ctr++;
            str += '</div></li>';
          });
          
          if(search != null){
            $('.message-list ul.items').html(str);
          }else{
            $('.message-list ul.items').append(str);
            var $target = $('html,body'); 
            $target.animate({scrollTop: $target.height()}, 1000);            
          }
          
          if($('.message-list .items li').length == res.totalrows || res.messages.length == 0){
            $('.show-section').addClass('d-none');
          }else{
            $('.show-section').removeClass('d-none');
          }                    

        }

    });  

  } 


  function displayMessageDetails(currpage, limit, pageUrl, refresh = false){

     $.ajax({
        url: pageUrl,
        dataType: 'json',
        type: 'POST',
        data: {currpage : currpage, limit:limit },
        success: function(res){
          var str = '';
          var ctr = 1;
          var content = '';
          var photo = '';
          var created = '';
          var id = '';

          if(res.messages.length == 0){
            str += '<li class="no-data">No message.</lit>';
            $('.show-section').addClass('d-none');
          }else{
            $('.no-data').remove();
          }

          $.each(res.messages, function(key, val){
            if(ctr > limit)
              return;
            content = val.messages.content;
            created = val[0].msg_date;
            if(val[0].owned){
              photo = val.touser.to_image;
              id = val.touser.to_id;
            }else{
              photo = val.fromuser.from_image;
              id = val.fromuser.from_id;
            }
            
            if(photo == ''){
              photo = 'default-photo.png';
            }

            str += '<li class="nopadding border"><div class="row">';
            if(val[0].owned == 1){
              str += '<div class="col-md-10"><button data-id="'+val.messages.id+'" class="delete-detail float-left">X</button><p class="nopadding"><span class="d-block content-span border">'+content+'</span><span class="d-block created-span border">'+created+'</span> </p> </a> </div><div class="col-md-2 text-center border"> <a href="/message_board/profile/'+id+'"><img src="/message_board/img/'+photo+'" class="photo" alt=""></a> </div> ';
            }else{
              str += '<div class="col-md-2 text-center border"> <a href="/message_board/profile/'+id+'"><img src="/message_board/img/'+photo+'" class="photo" alt=""></a> </div> <div class="col-md-10"><button data-id="'+val.messages.id+'" class="delete-detail float-right">X</button><p class="nopadding"><span class="d-block content-span border">'+content+'</span><span class="d-block created-span border">'+created+'</span> </p></div>';              
            }


            ctr++;
            str += '</div></li>';
          });
          // console.log(str);
          
          
          if(refresh){
            $('.message-list ul.items').html(str);
          }else{
            $('.message-list ul.items').append(str);
          }

          // var $target = $('html,body'); 
          // $target.animate({scrollTop: $target.height()}, 1000);           
          
          if($('.message-list .items li').length == res.totalrows || res.messages.length == 0){
            $('.show-section').addClass('d-none');
          }else{
            $('.show-section').removeClass('d-none');
          }                    

        }

    });   
  }  