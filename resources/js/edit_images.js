function displayEditImageGallery(edit_post){
    if(typeof edit_post !== 'undefined'){
        var images = edit_post;                   //array of paths to images
            let post_element = document.getElementById("edit_images"); //element to put gallery

            var content_string = `<div class="content_row">`;
            if(images.length == 1 && images[0] !== ""){
                content_string += `
                <div class="content_column">
                    <div class="edit-image-container" id="image-container-${images[0]}">
                        <img class="rounded img-fluid" src="${images[0]}" alt="${images[0]}">
                        <button class="btn" id="delete-button-${images[0]}" onclick="removeImage('${images[0]}');">delete</button>
                    </div>
                </div>`;
            }else if (images.length == 2 || images.length == 4) {
                var idx = 0;
                for(i=0;i<2;i++){
                    content_string += `<div class="content_column_2">`
                    for(j=0;j<Math.ceil(images.length/2);j++){
                        if(images[idx] !== undefined && images[idx] !== null){
                            content_string += `<div class="edit-image-container" id="image-container-${images[idx]}">
                                <img class="rounded img-fluid" src="${images[idx]}" alt="${images[idx]}">
                                <button class="btn" id="delete-button-${images[idx]}" onclick="removeImage('${images[idx]}');">delete</button>
                            </div>
                            `
                            idx += 1;
                        }else{
                            break;
                        }
                    }
                    content_string += `</div>`;
                }
            }else if (images.length == 3 || images.length > 4){
                var idx = 0;
                for(i=0;i<3;i++){
                    content_string += `<div class="content_column_3">`
                    for(j=0;j<Math.ceil(images.length/3);j++){
                        if(images[idx] !== undefined && images[idx] !== null){
                            content_string += `<div class="edit-image-container" id="image-container-${images[idx]}">
                                <img class="rounded img-fluid" src="${images[idx]}" alt="${images[idx]}">
                                <button class="btn" id="delete-button-${images[idx]}" onclick="removeImage('${images[idx]}');">delete</button>
                            </div>
                            `
                            idx += 1;
                        }else{
                            break;
                        }
                    }
                    content_string += `</div>`;
                }
            } else {
                
            }
            var post_string = content_string + `</div>`;
            post_element.insertAdjacentHTML("beforeend",post_string);
    }
}

window.displayEditImageGallery = displayEditImageGallery;