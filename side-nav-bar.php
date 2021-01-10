<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./styles/side-nav-bar.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
  <nav class="side-nav-bar">
    <div class="drop-btn">
      Categories <span class="fas fa-caret-down"></span>
    </div>
    <div class="tooltip">
    </div>



    <div class="wrapper">

      <ul class="menu-bar">

        <!-- parents containers -->

        <li class="nav-item-parent men" onclick="navigate(this.classList,true)">
        
        <a>
            <div class="icon">
            </div>
            men 
          </a>
        
        </li>

      </ul>

      <!-- childs containers -->

      <ul class="nav-item-child men" >

        <li class="arrow back-setting-btn" onclick="navigate(this.parentElement.classList,false)" ><span class="fas fa-arrow-left"></span>All</li>
        <li><a>
            <div class="icon">
            </div>
            Accessories
          </a></li>
        
      </ul>

    </div>
  </nav>

  <script>


    const drop_btn = document.querySelector(".drop-btn span");
    const tooltip = document.querySelector(".tooltip");
    const menu_wrapper = document.querySelector(".wrapper");

    drop_btn.onclick = (() => {
      menu_wrapper.classList.toggle("show");
      tooltip.classList.toggle("show");
    });


    function navigate(classes,isParent){

      const parentContainer = document.querySelector(".menu-bar")
      const child = document.querySelector(".nav-item-child" + "." + classes[1] )
      if(isParent){
      parentContainer.style.display = "none";
      child.style.display = "block";
      }else{
        parentContainer.style.display = "block";
        child.style.display = "none";
      }
    }
  </script>

</body>

</html>