<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wikipedia viewer application</title>

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/14c79cd15d.js"></script>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Tether.io -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
  </head>
  <body>
    <div class="container-fluid content">
      <div class="row ">
        <div class="col-sm-10 col-xs-12 offset-sm-1 search-box input-group">
          <a href="https://en.wikipedia.org/wiki/Special:Random" target="_blank">
            <div class="random-page-icon">
              <i class="fa fa-random" aria-hidden="true"></i>
            </div>
          </a>
          <input type="text" name="search-for" id="search-for" placeholder="Let's Wiki!" >
          <div class="search-icon">
            <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-10 col-xs-12 offset-sm-1 search-results">
        </div>
      </div>
    </div>
  <footer class="copyright">Written and coded by <a href="https://www.dcmf.hu"><img class="dcmf-logo" src="dcmf-letters.png" alt="David's Code ManuFactory logo"/></a></footer>
  </body>
<script>
  $(document).ready(function(){
    var getSearchResults = function(){
      $('footer').addClass('animated slideOutDown').remove();

      var searchFor = $('#search-for').val();
      var searchForHTML = encodeURI(searchFor);
      $.ajax({
        url: 'https://en.wikipedia.org/w/api.php?action=query&list=search&format=json&srprop=title|snippet|size&srsearch='+searchForHTML,
        dataType: 'jsonp',
        type: 'POST',
        headers: { 'Api-User-Agent': 'Example/1.0' },
        success: function(response){
          //  alert(JSON.stringify(response));
          $.each(response.query.search, function(index, value){

              var searchResultElement = '<a href="http://en.wikipedia.org/wiki/'+value.title+'" target="_blank">\
                                          <div class="search-result animated slideInRight">\
                                            <h4><span>'+value.title+'</span></h4>\
                                            <p>'+value.snippet+'</p>\
                                          </div>\
                                        </a>'
              setTimeout(function(){
                $('.search-results').append(searchResultElement);
              }, index*300);
          });
          setTimeout(function(){
            $('footer').removeClass('animated slideOutDown').show();
            $('.search-results').parent().parent().append('<footer class="copyright">Written and coded by <a href="https://www.dcmf.hu"><img class="dcmf-logo" src="dcmf-letters.png" alt="David\'s Code ManuFactory logo"/></a></footer>')

          }, 3000);
        },

        error: function(message){
          alert('oops');
        }
      });
    };

    $('.search-icon').on('click', function(){
      if ($('.content').height() !== '15%'){
        $('.content').animate({
          height: '15%'
        }, 500);
      }

      $('.search-results').addClass('animated fadeOut');

      setTimeout(function(){
        $('.search-results').empty().removeClass('animated fadeOut');
        getSearchResults();
      }, 400);
    });

    $(document).keypress(function(e){
      if (e.which == 13){
        if ($('.content').height() !== '15%'){
          $('.content').animate({
            height: '15%'
          }, 500);
        }

        $('.search-results').addClass('animated fadeOut');

        setTimeout(function(){
          $('.search-results').empty().removeClass('animated fadeOut');
          getSearchResults();
        }, 400);
      }
    });
  });

</script>
</html>
