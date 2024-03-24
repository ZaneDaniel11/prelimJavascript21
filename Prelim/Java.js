
$("#addCategory").click(function (e) { 
    var categoryName = document.querySelector("#categoryName").value;
    if(categoryName.length > 0){
        $.ajax({
            url:  "Category_insert.php",
            type: "GET",
            data: {
                name: categoryName
            }
        }).done(function(data){
            let result = JSON.parse(data);
            console.log(result);
            if(result.res == "success"){
                location.reload();
            }
        })
    }
    
});