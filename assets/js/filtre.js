
    $(document).ready(
        function() {
          
            $(".my-input").keypress(function(event) {
  
              var key = event.which;
              if (key == 13 || key == 44) {
  
                event.preventDefault();
                var tag = $(this).val();
  
                if (tag.length > 0) {
                  $("<span class='tag' style='display:none'><span class='close'>&times;</span>" + tag + " </span>").insertBefore(this).fadeIn(100);
                  $(this).val("");
                  changeState($(this).get(0).parentElement);
                }
  
              }
            });

      

          $('.tags').on("click", ".close", function() {
            $(this).parent("span").fadeOut(100);
            element = $(this).get(0).parentElement.parentElement
            $(this).parent("span").remove();     
            changeState(element);  
          });
        });
  
  
      // getting all required elements
      const searchWrapper = document.querySelectorAll(".search-input");
  
      function select(element) {
  
        let selectData = element.textContent;
        const searchWrapper = element.parentElement.parentElement.parentElement.parentElement;
        const inputBox = searchWrapper.querySelector("input");
        inputBox.value = selectData;
        searchWrapper.classList.remove("active");

      }
  
      let suggestions = { "id1" : [ "havana", "bertlaut"] , "id2" : ["Mamacito"]}
  
      // if user press any key and release
      for (let i = 0; i < searchWrapper.length; i++) {
  
        let elem = searchWrapper[i];
  
        const inputBox = elem.querySelector("input");
  
        const suggBox = elem.querySelector(".autocom-box");
  
        let linkTag = elem.querySelector("a");
  
        let id = elem.id.substr(21);
  
        suggestions["id" + id] = [];
  
        inputBox.onkeyup = (e) => {
          let userData = e.target.value; //user enetered data
          let emptyArray = [];
          if (userData) {
  
            emptyArray = suggestions['id' + id].filter((data) => {
              //filtering array value and user characters to lowercase and return only those words which are start with user enetered chars
              return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
            });
  
            emptyArray = emptyArray.map((data) => {
              // passing return data inside li tag
              return data = '<li>' + data + '</li>';
            });
  
            elem.classList.add("active"); //show autocomplete box
            showSuggestions(emptyArray);
            let allList = suggBox.querySelectorAll("li");
            for (let i = 0; i < allList.length; i++) {
              //adding onclick attribute in all li tag
              allList[i].setAttribute("onclick", "select(this)");
            }
          } else {
            elem.classList.remove("active"); //hide autocomplete box
          }
        }
  
  
  
        function showSuggestions(list) {
          let listData;
          if (!list.length) {
            userValue = inputBox.value;
            listData = '<li>' + userValue + '</li>';
          } else {
            listData = list.join('');
          }
          suggBox.innerHTML = listData;
        }
  
  
        let dataBuffer;
  
  
        let fetchSuggestions = new Promise((resolve, reject) => {
  
        debugger;
          $.ajax({
            type: 'POST',
            url: './../homepage/php-filtre-process.php',
            dataType: "json",
            data: {
              suggestions_id: id
            },
            success: function(data) {
              console.log(id)
              console.log('SUCCESS BLOCK');
              dataBuffer = data;
              console.log(data);
              if(data != false){
              resolve(dataBuffer);
              debugger;
              }else{
                reject('nothing found')
              }
            },
            error: function(data) {
              debugger;
              console.log('ERROR BLOCK');
              console.log(data);
              reject('ERROR BLOCK');
            }
          })
          debugger;
  
        }
        
        )
        fetchSuggestions.then(fetchedData =>{
          debugger;


          for (var prop in fetchedData) {
            if (Object.prototype.hasOwnProperty.call(fetchedData, prop) && prop == "value_name") {
               suggestions['id' + id].push(fetchedData[prop]);
               debugger;
            }
        }
        debugger;
        
          console.log(suggestions['id' + id])
        })
  
      }
  