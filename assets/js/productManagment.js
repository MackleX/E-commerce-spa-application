function sendRequest(dataTpye, callback, data,elem = 0) {

    console.log(data);
    debugger
 

    $.ajax({
        type: 'POST',
        url: '../userpanel/productManagementProcess.php',
        dataType: dataTpye,
        data: data,
        success: function (data) {
            callback(data,elem);
            debugger;
        },
        error: function (data) {
            console.log(data);
            debugger;

        }
    })


}

function addValueBackend(data){
    alert(data)

}

function deleteValueBackend(data,elem){
    alert(data)
    if(data == 'SUCCESS'){
        $(elem).parent().remove()
    }
}
function changeOptionsBackend(date){
    alert(data)
}
function updateMgProductModal(data) {

    let optionshtml = '';


    productName = data['product_name']
    productPrice = data['product_price']
    productDescription = data['product_description']
    prouctQuantity = data['product_qty']
    productSlogan = data['product_slogan']
    productSellerName = data['client_name']
    productSellerId = data['client_id']

    for (var prop in data['options']) {




        optionshtml += `<table class="table ${prop}">

       <thead>
           <tr class="text-center">
               <th class="text-center" style="width:100%">
                   ${prop}
               </th>
           </tr>
       </thead>
       
       <tbody>
        `


        for (var option in data['options'][prop]) {

            optionshtml +=
                `
           <tr>
               <td class="text-center ${prop} ${data['options'][prop][option][0]}">
                ${data['options'][prop][option][0]} : ${data['options'][prop][option][1]}
                   <button class="btn btn-primary btn-fab btn-fab-mini btn-round deleteValueButton">
                       <i class="material-icons">delete</i>
                   </button>
               </td>

           </tr>
           `
        }

        optionshtml +=
            `
               <td>


                   <form id="${prop}" onsubmit="return addValue(this)">
                       <div class="row">
                           <div class="col">
                               <input name="valName" type="text" class="form-control" placeholder="Option name" required>
                           </div>
                           <div class="col">
                               <input name="valPrice" type="number" class="form-control" placeholder="Option Added price" required>
                           </div>

                       </div>
                       <div class="text-center">
                           <button type="submit" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                               <i class="material-icons">note_add</i>
                           </button>
                       </div>
                   </form>




               </td>

       </tbody>

   </table>
   `


        html = `

        <div class="table-responsive">
        <table class="table">
            <thead class=" text-primary">
                <th>
                    name
                </th>

                <th style="width: 10%;">
                    qty
                </th>



                <th style="width: 10%;">
                    price
                </th>

                <th class="text-center">
                    options
                </th>

            </thead>
            <tbody>

                <tr>
         
    <form id="productChange" onsubmit="return productChange(this)">
    <td style="vertical-align:top;">

        <input form="productChange" name="name" type="text" class="form-control" style="width:100%; vertical-align: top;" placeholder="${productName}" required>
    </td>
    <td style="vertical-align:top;">
        <input form="productChange" name="qty" type="text" class="form-control" style="width:100%; vertical-align: top;" placeholder="${prouctQuantity}" required>                                        

    </td>
    <td style="vertical-align:top;">
        <input form="productChange" name="price" type="text" class="form-control" style="width:100%; vertical-align: top;" placeholder="${productPrice}" required min="1">
    </td>
</form>

                    <td>
                    `


                        +optionshtml + 
                     




                    `
                    </td>


                </tr>




                </td>

                </tr>

            </tbody>
        </table>

    </div>


    `

    $(".modal-body").get(0).innerHTML = html;
        debugger;


    }
}