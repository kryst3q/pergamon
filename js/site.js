document.addEventListener('DOMContentLoaded', function() {
    
    $.getJSON('http://localhost/pergamon/api/books.php', function (books) {
       
        $("#books").append("<ul id='book' class='list-group'></ul>");
        
        for (var book of books) {
            $("#book").append("<li class='list-group-item' style='' data-id='" + book['id'] + "'>" + book['title'] + " <span class='badge'><a href='#' style='color: #fff'>Delete</a></span></li>");
            $("#book").append("<div class='hide well well-sm' id='book" + book['id'] + "'></div>");
        }
        
        $("a").click(function(e) {
            
            e.preventDefault();
            e.stopPropagation();
//            console.log();
            $.ajax({
                url: 'http://localhost/pergamon/api/books.php?id='+$(this).prev().prev().data("id"),
                type: 'DELETE',
                data: "id="+$(this).parent().parent().data("id")
            }).done(function(data){
        //       odświeżanie
                console.log('ok');
            }).fail(function(xhr,status,errorThrown) {
                console.log(xhr);
                console.log(status);
                console.log(errorThrown);
            });

        });
        
        $("li").click(function(li) {
        
            $(this).next().toggleClass("hide");
            $(this).next().next().toggleClass("hide");
            $.getJSON('http://localhost/pergamon/api/books.php?id='+$(this).data("id"), function (book) {
                
                $("div#book" + book[0]['id']).html("<p>Author: " + book[0]['author'] + "</p><p>Description: " + book[0]['description'] + "</p>" + "<form action='index.html' method='POST' class='form-horizontal' id='updateBook'><h5 class='text-info'>Update info<h5><hr><div class='form-group'><label class='control-label col-sm-2' for='newAuthor'>New author: </label><div class='col-sm-10'><input type='text' class='form-control' id='newAuthor' name='newAuthor'></div></div><div class='form-group'><label class='control-label col-sm-2' for='newTitle'>New Title: </label><div class='col-sm-10'><input type='text' class='form-control' id='newTitle' name='newTitle'></div></div><div class='form-group'><label class='control-label col-sm-2' for='newDescription'>New description:</label><div class='col-sm-10'><textarea class='form-control' id='newDescription' name='newDescription'></textarea></div></div><div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' class='btn btn-default'>Update</button></div></div></form>");
                
                $("form").on("submit", function(e) {
                    
                    e.preventDefault();

                    $.ajax({
                        url: 'http://localhost/pergamon/api/books.php?id='+$(this).parent().prev().data("id"),
                        type: 'PUT',
                        data: $(this).serialize()
                    }).done(function(data){
                        $("#feedback").append("<span class='text-success'>changed book data</span>").children().delay(2000).fadeOut('slow');;
                        //odświeżanie
                    }).fail(function(xhr,status,errorThrown) {
                        console.log(xhr);
                        console.log(status);
                        console.log(errorThrown);
                    });
                    console.log('ok');
                });
            
            });
        });
        
    });
    
    $("form").on("submit", function(e) {
        
        e.preventDefault();
        
        $.ajax({
            url: 'http://localhost/pergamon/api/books.php',
            type: 'POST',
            data: $(this).serialize()
        }).done(function(data){
            $("#feedback").append("<span class='text-success'>added new book</span>").children().delay(2000).fadeOut('slow');;
            
        }).fail(function(xhr,status,errorThrown) {
            console.log(xhr);
            console.log(status);
            console.log(errorThrown);
        });
        
    });
    
});


