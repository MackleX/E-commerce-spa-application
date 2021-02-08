document.querySelectorAll('.stateElement').forEach(item => {
    item.addEventListener('click', event => {
        if (item.classList.contains('clicked')) {

            if (!item.classList.contains('sideNavElement')) {
                changeState(item)
                item.classList.remove('clicked')

            } else {
                changeState(item.parentElement.parentElement)
                item.classList.remove('clicked')
                item.parentElement.parentElement.classList.remove('clicked')
            }


        }

        else {
            if (!item.classList.contains('sideNavElement')) {
                changeState(item)
                item.classList.add('clicked')

            } else {

                item.classList.add('clicked')
                changeState(item.parentElement.parentElement)
                item.parentElement.parentElement.classList.add('clicked')

            }
        }
        event.stopPropagation();

    })
})

function changeState(item) {
    if (item.classList.contains('topCategory')) {
        let topCatId = item.classList[3].substr(1);
        globalRequestState.updateTopCat(topCatId);
    }
    else if (item.classList.contains('nav-item-parent')) {
        let midCatId = item.classList[1].substr(1)
        globalRequestState.updateMidCat(midCatId);
    }
    else if (item.classList.contains('endCategory')) {
        let endCatId = item.classList[1].substr(1)
        globalRequestState.updateEndCat(endCatId);
    }
    else if (item.classList.contains('tags')) {
        let tagsArray = []
        let optionId = item.parentElement.id.substr(11)
        const items = item.querySelectorAll(".tag")
        items.forEach(element => {
            text = element.innerText;
            if (text[0] == '×') { text = text.substr(2) }
            tagsArray.push(text);

        })

        globalRequestState.updatefiltreOption(optionId, tagsArray)
        console.log("option id is" + optionId + "arrays value are" + tagsArray);
    }
    else if (item.classList.contains('description-button')) {
        let $id = item.parentElement.parentElement.parentElement.classList[1];
        globalRequestState.currentItemId = $id;
        globalRequestState.sendRequest("json", updateModal, { prodId: ($id) });
    }
}

class RequestState {
    constructor() {

        this.topCat = [];
        this.midCat = [];
        this.endCat = [];

        this.currentItemId = 0;


        this.filtreOption = [];


    }
    updateRequestStateArrays(requestStateArray, id) {

        if (this[requestStateArray].includes(id)) {
            this[requestStateArray] = this[requestStateArray].filter(value => {
                return value != id;
            })
        } else {
            this[requestStateArray].push(id)
        }

        debugger;
        this.sendRequest("json", updategrid, {
            jsondata: JSON.stringify(this)
        })
        debugger;
    }

    updateTopCat(topCatId) {
        this.updateRequestStateArrays('topCat', topCatId)
    }
    updateMidCat(midCatId) {
        this.updateRequestStateArrays('midCat', midCatId)
    }
    updateEndCat(endCatId) {

        this.updateRequestStateArrays('endCat', endCatId)
    }
    updatefiltreOption(optionId, tagsArray) {

        let isNotFound = true;

        for (var elem of this.filtreOption) {

            if (elem.hasOwnProperty('option_id') && elem['option_id'] == optionId) {
                elem['array'] = tagsArray;
                isNotFound = false;
                break;
            }

        }
        if (isNotFound) {
            this.filtreOption.push({ option_id: optionId, array: tagsArray })
        }

        this.sendRequest("json", updategrid, {
            jsondata: JSON.stringify(this)
        })
    }

    sendRequest(dataTpye, callback, data) {

       debugger;

        $.ajax({
            type: 'POST',
            url: '../HOMEPAGE/php-filtre-process.php',
            dataType: dataTpye,
            data: data,
            success: function (data) {
                debugger;
                callback(data);
        
            },
            error: function (data) {
                console.log("error");
                console.log(data);
                debugger;

            }
        })


    }
}



function updategrid(data) {
    const grid = document.querySelector("#grid")

    let html = '';
    if(data.length == 0 ){ $("#result_span").get(0).innerText = "No result is found"}else{$("#result_span").get(0).innerText = "Showing: " + data.length + " sresult"}
    debugger;
    data.forEach(element => {
            debugger;

            product_id = element['product_id'];
            product_name = element['product_name'];
            product_price = element['product_price'];
            product_principale_photo = element['product_featured_photo']



            html +=
                `
            <div class="product ${product_id}">

            <div class="info-large">

                <h4>${product_name}</h4>

                <div class="price-big">
                    <span>${product_price} Dh</span>
                </div>

                <button class="add-cart-large">Add To Cart</button>
                <button class="description-button-large stateElement">description</button>

            </div>
            <div class="make3D">
                <div class="product-front">
                    <div class="shadow"></div>
                    <img src="/refactoring/assets/uploads/product_photos/${product_principale_photo}" alt="" />
                    <div class="image_overlay"></div>
                    <div class="add_to_cart">Add to cart</div>
                    <div class="view_gallery">View gallery</div>
                    <div class="description-button stateElement">description</div>
                    <div class="stats">
                        <div class="stats-container">
                            <span class="product_price">${product_price} Dh</span>
                            <span class="product_name">${product_name}</span>
                            <p>
                       
                            </p>

                            <div class="product-options">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-back">
                    <div class="shadow"></div>
                    <div class="carousel">
                        <ul class="carousel-container">
                        </ul>
                        <div class="arrows-perspective">
                            <div class="carouselPrev">
                                <div class="y"></div>
                                <div class="x"></div>
                            </div>
                            <div class="carouselNext">
                                <div class="y"></div>
                                <div class="x"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flip-back">
                        <div class="cy"></div>
                        <div class="cx"></div>
                    </div>
                </div>
            </div>
        </div>
        `

    })
    grid.innerHTML = '';
    grid.innerHTML = html;
    menu();
}





















function updateModal(data) {
    let optionshtml = '';
    for (var prop in data['options']) {


        optionshtml +=
            `
        <div class="attrib size">
            <p class="header">${prop}</p>
            <div class="options">
        `

        let count = 0;

        for (var option in data['options'][prop]) {
            if (count == 0) {
                debugger;
                optionshtml +=
                    `
            <input id="${data['options'][prop][option][0]}" type="radio" name="${prop}" value="${data['options'][prop][option][0]}" style="display:none;" checked>
            <label for="${data['options'][prop][option][0]}">
            <div class="price_${data['options'][prop][option][1]} activ option">${data['options'][prop][option][0]}</div>
            </label>
            `
            } else {
                optionshtml +=
                    `
                
                <input id="${data['options'][prop][option][0]}" type="radio" name="${prop}" value="${data['options'][prop][option][0]}" style="display:none;">
                <label for="${data['options'][prop][option][0]}">
                <div class="price_${data['options'][prop][option][0][1]} option">${data['options'][prop][option][0]}</div>
                </label>


                `
            }
            count++;
        }
        optionshtml +=
            `
        </div>
        </div>
        `
    }
    console.log(optionshtml);

    imageshtml = `<div class="imgs">`
    let count = 0;
    for (var prop in data['images']) {

        if (count == 0) {
            imageshtml += `<img class="activ" src="../assets/uploads/product_photos/${data['images'][prop]}" alt="img ${count + 1}">`

        } else {
            imageshtml += `<img src="../assets/uploads/product_photos/${data['images'][prop]}" alt="img ${count + 1}">`
        }

        count++;
    }

    imageshtml += `</div>`



    productId = data['product_id']


    productName = data['product_name']
    productPrice = data['product_price']
    productDescription = data['product_description']
    prouctQuantity = data['product_qty']
    productSlogan = data['product_slogan']
    productSellerName = data['client_name']
    productSellerId = data['client_id']
    html =
        `

    <div class="container" style="position:relative; ">

        <i class="fas fa-times-circle closeButton" style="position:absolute; top:0px; FIpright:10px; z-index:1600; font-size:2em; cursor:pointer;"></i>
        <div class="info">
            <h3 id="name" class="name ${productId}">${productName}</h3>
            <h1 class="slogan">${productSlogan}</h1>
            <a class="price" style="font-size:1rem;" href='../profile/profile_container.php?id=${productSellerId}' ><i class="material-icons">face</i>Check product seller profile ${productSellerName}</a>
            <p class="price">Unit price:${productPrice} Dh</p>

            


            <div class="attribs">

                <div class="attrib">
                    <p class="header"> Description </p>
                    <p>${productDescription}</p>
                    <span onclick="copyProudctLink(${productId})" >Copy product link</span>


                </div>

                <form name="product" onsubmit="return validateForm()">

                <label for="quantity">Quantity (between 1 and 99):</label>
                <input type="number" id="quantity" name="quantity" min="1" max="99" required>

                `+ optionshtml + `

                <input id="submitButton" type="submit" value="isCart" name="submitProduct" style="display:none;">
                <input id="submitButton2" type="submit" value="isNotCart" name="submitProduct" style="display:none;">

                <div class="buttons">
                    <label for="submitButton" class="product-modal-button">
                        <div type="button" class="button">Add to cart</div>
                    </label>
                    <label for="submitButton2">
                        <div type="button" class="button colored" data-toggle="modal" data-target="#exampleModalLong">Buy now</div>
                    </label>
                    

                    <button type="button" class="button colored" data-toggle="modal" data-target="#reportModal">
                    Report item
                    </button>
                    
                </div>
        </div>

        </form>




            

            <div class="preview">
                <div class="imgs">

                `+ imageshtml + `

                <div class="zoomControl"></div>
                <div class="closePreview"></div>
                <div class="movControls">
                    <div class="movControl left"></div>
                    <div class="movControl right"></div>
                </div>
            </div>

        </div>

`
    debugger;
    $(".myproductmodalcontainer").get(0).innerHTML = html;

    console.log("this is my html");
    modalscript() //check item grid
    console.log(html);


}


function updateModalProduct(data) {

    for (var option in data['options'][prop]) {
        if (count == 0) {
            debugger;
            optionshtml +=
                `
        <input id="${data['options'][prop][option][0]}" type="radio" name="${prop}" value="${data['options'][prop][option][0]}" style="display:none;" checked>
        <label for="${data['options'][prop][option][0]}">
        <div class="price_${data['options'][prop][option][1]} activ option">${data['options'][prop][option][0]}</div>
        </label>
        `
        } else {
            optionshtml +=
                `
            
            <input id="${data['options'][prop][option][0]}" type="radio" name="${prop}" value="${data['options'][prop][option][0]}" style="display:none;">
            <label for="${data['options'][prop][option][0]}">
            <div class="price_${data['options'][prop][option][0][1]} option">${data['options'][prop][option][0]}</div>
            </label>


            `
        }
        count++;
    }
}

globalRequestState = new RequestState();
