const { forEach } = require("lodash");

function displayPostGallery(element, html_string){
    element.insertAdjacentHTML("beforeend",html_string);
}

(function(){
    if(posts){
        posts.forEach(function(p) {
            var images = p.images.replace(/ /g,'').split(',');                   //array of paths to images
            let post_element = document.getElementById("post"); //element to put gallery

            var title_string = `<h1>${p.title}</h1>
                                <div class="content_row">`;
            var content_string = ``;
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
            content_string += `<p>${p.description}</p>`;
            var post_string = title_string + content_string + `</div>`;
            displayPostGallery(post_element, post_string);
        });
    }
}())