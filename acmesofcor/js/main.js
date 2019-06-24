$(document).ready(function(){
    $('#LoginView').hide();
    $('#historyView').hide();
    $('#favoriteView').hide();

    $('#loginbtn').click(function(){
        $('#LoginView').show();
        $('#searchView').hide();
        $('#historyView').hide();
        $('#favoriteView').hide();
    });

    $('#history').click(function(){
        $('#historyView').show();
        $('#searchView').hide();
        $('#LoginView').hide();
        $('#favoriteView').hide();
    });

    $('#history').click(function(){
        $('#historyView').hide();
        $('#searchView').hide();
        $('#LoginView').hide();
        $('#favoriteView').show();
    });

    $('.loginlink').click(function(){
        $('#LoginView').hide();
        $('#searchView').show();
        $('#historyView').hide();
    });
});


// function GetGiphyData(){
//     //P2oCKJO7QKeaqYFHiRVFV0BEf5VpPygi
//     var searchGif = "Cat";
//     var url = 'http://api.giphy.com/v1/gifs/search?api_key=P2oCKJO7QKeaqYFHiRVFV0BEf5VpPygi&q='+searchGif;
//     fetch(url)
//     .then(data => data.json())
//     .then( response =>{
//         console.log(response);
//         var gifArrays = response.data;
//         var random = Math.floor(Math.random() * gifArrays.length);
//         var firstI = gifArrays[random];
//         var getTheGif = firstI.images.fixed_width.url;
//         document.getElementsByClassName('gallery')[0].innerHTML = "";
//         var iDiv = document.createElement('div');
//         iDiv.className = 'row';
//         var iDiv2 = document.createElement('div');
//         iDiv2.className = 'col col-mid-3';
//         iDiv.appendChild(iDiv2);

        
//         document.getElementsByClassName('gallery')[0].appendChild(iDiv);
//         for(var i = 0; i < gifArrays.length; i++){
//             var img = gifArrays[i];
//             getTheGif = img.images.fixed_width.url;
//             var imgTeg = document.createElement('img');
//             imgTeg.className = 'img-thumbnail';
//             imgTeg.src = getTheGif;
//             iDiv2.appendChild(imgTeg);
            
//             //document.querySelector('.img-thumbnail').setAttribute('src',getTheGif);
//         }

//         // document.querySelector('#gifCont').setAttribute('src',getTheGif);
//         // document.querySelector('#gifCont3').setAttribute('src',getTheGif);
//         // document.querySelector('#gifCont4').setAttribute('src',getTheGif);
//         // document.querySelector('#gifCont5').setAttribute('src',getTheGif);
//     })
//     .catch(error => console.log(error));
// }