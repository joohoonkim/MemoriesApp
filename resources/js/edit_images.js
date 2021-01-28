function displayPostGallery(element, html_string){
    element.insertAdjacentHTML("beforeend",html_string);
}

(function(){
    if(typeof edit_post !== 'undefined'){
        var images = edit_post.images.replace(/ /g,'').split(',');                   //array of paths to images
            let post_element = document.getElementById("edit_images"); //element to put gallery

            var content_string = `<div class="content_row">`;
            if(images.length == 1){
                content_string += `
                <div class="content_column">
                    <img class="rounded img-fluid" src="${imagesURL}/${images[0]}" alt="${images[0]}">
                </div>`;
            }else if (images.length == 2 || images.length == 4) {
                var idx = 0;
                for(i=0;i<2;i++){
                    content_string += `<div class="content_column_2">`
                    for(j=0;j<Math.ceil(images.length/2);j++){
                        if(images[idx] !== undefined && images[idx] !== null){
                            content_string += `<img class="rounded img-fluid" src="${imagesURL}/${images[idx]}" alt="${images[idx]}">`
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
                            content_string += `<img class="rounded img-fluid" src="${imagesURL}/${images[idx]}" alt="${images[idx]}">`
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
            displayPostGallery(post_element, post_string);
    }
}())