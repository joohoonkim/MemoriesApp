function uploadNewImage(post){
    var reader = new FileReader();
    reader.onload = (function(theFile){
        var filename = theFile.name;

        return function(e){
            let row_element = document.getElementById('content_row');
            var image_string = `
            <div class="content_column">
                <div class="edit-image-container" id="image-container-${filename}">
                    <img class="rounded img-fluid" src="${e.target.result}" alt="${filename}">
                    <button class="btn" id="delete-button-${filename}" onclick="removeImage('${filename}');">delete</button>
                </div>
            </div>`;
            row_element.insertAdjacentHTML("beforeend",image_string);
        };

    })(post.file);
    reader.readAsDataURL(post.file);
}

function uploadOriginalImage(post,imagesURL){
    let row_element = document.getElementById('content_row');
    var image_string = `
    <div class="content_column">
        <div class="edit-image-container" id="image-container-${post}">
            <img class="rounded img-fluid" src="${imagesURL}/${post}" alt="${post}">
            <button class="btn" id="delete-button-${post}" onclick="removeImage('${post}');">delete</button>
        </div>
    </div>`;
    row_element.insertAdjacentHTML("beforeend",image_string);
}

function displayEditImageGallery(all_posts,imagesURL){
    if(typeof all_posts !== 'undefined'){
            let post_element = document.getElementById("edit_images"); //element to put gallery
            var content_string = `<div class="content_row" id="content_row"></div>`;
            post_element.insertAdjacentHTML("beforeend",content_string);
            for(i=0;i<all_posts.length;i++){
                if(typeof all_posts[i] === 'object'){
                    uploadNewImage(all_posts[i]);
                }else{
                    uploadOriginalImage(all_posts[i],imagesURL);
                }
            }
    }
}

window.displayEditImageGallery = displayEditImageGallery;