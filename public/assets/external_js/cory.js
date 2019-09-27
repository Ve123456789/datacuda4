$(document).ready(function() {

    //======= SLIDER ========//
    // $("#testimonial_slider").owlCarousel({
    //     loop: true,
    //     margin: 0,
    //     items: 1,
    //     nav: true,
    //     autoplay: false,
    //     mouseDrag: true,
    //     dots: false,
    //     navText: ["<img src='assets/img/Arrow_left.png'>","<img src='assets/img/Arrow_right.png'>"]
    // });

    $(window).scroll(function(){
        if ($(window).scrollTop() >= 50) {
            $('header').addClass('fixed-header');
            $('header').addClass('visible-title');
        }
        else {
            $('header').removeClass('fixed-header');
            $('header').removeClass('visible-title');
        }
    });

    $("#log_in").click(function(){
        $(".log_in").fadeIn();
        $(".main_tag").addClass("main_wrapper_blur");
    });
    $(".m_close_btn").click(function(){
        $(".log_in").fadeOut();
        $(".main_tag").removeClass("main_wrapper_blur");
    });

    
    $("#sign_up").click(function(){
        $(".sign_up").fadeIn();
        $(".main_tag").addClass("main_wrapper_blur");
    });
    $(".m_close_btn").click(function(){
        $(".sign_up").fadeOut();
        $(".main_tag").removeClass("main_wrapper_blur");
    });


    $(document).on("click","#navBtn111",function(event){
        $(".inner_nav").toggle();
        event.preventDefault();
       // $( this ).off( event );
    });


    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    // HEADER

    $('.inner_nav_Bar li a').click(function(){
        $('li a').removeClass("active");
        $(this).addClass("active");
    });

    // $("#my_account_nav").click(function(){

    //     $("#my__Account_data").show();
    //     $("#finance_data").hide();
    //     $("#plan_data").hide();
    //     $("#biling_data").hide();
    // });

    // $("#plan_nav").click(function(){
    //     $("#plan_data").show();
    //     $("#finance_data").hide();
    //     $("#my__Account_data").hide();
    //     $("#biling_data").hide();
    // });

    // $("#finance_nav").click(function(){
    //     $("#finance_data").show();
    //     $("#plan_data").hide();
    //     $("#my__Account_data").hide();
    //     $("#biling_data").hide();
    // });
    
    // $("#biling_nav").click(function(){
    //     $("#biling_data").show();
    //     $("#finance_data").hide();
    //     $("#plan_data").hide();
    //     $("#my__Account_data").hide();
    // });

    // profile_nav
    $('.profile_nav li a').click(function(){
        $('li a').removeClass("active");
        $(this).addClass("active");
    });

    $("#my_profile").click(function(){
        $("#profile_data").show();
        $("#company_data").hide();
    });

    $("#company_profile").click(function(){
        $("#company_data").show();
        $("#profile_data").hide();
    });

/*    // DATE PICKER
    $('#my-element').datepicker([options])
    // Access instance of plugin
    $('#my-element').data('datepicker');*/

});


function copyLink() {
    var copyText = document.getElementById("copy_link");
    copyText.select();
    document.execCommand("copy");
    // return true;
  }





//=========================
//      INPUT FILE
//=========================

"use strict"

var fileList = []


var elem = document.getElementById("file");
if(typeof elem !== 'undefined' && elem !== null) {
// get file list when user click on Select button
document.getElementById("file").addEventListener("change", (e) => {
    fileList = e.target.files;
    handleFiles(fileList);
}, false)

}
var fileDrag = document.getElementById("fileDrag");
if(typeof fileDrag !== 'undefined' && fileDrag !== null) {
    fileDrag.addEventListener("dragenter", (e) => {
        e.stopPropagation()
        e.preventDefault()

        fileDrag.classList.add("dragenter")
    }, false)

    fileDrag.addEventListener("dragover", (e) => {
        e.stopPropagation()
        e.preventDefault()
    }, false)

    fileDrag.addEventListener("dragleave", (e) => {
        e.stopPropagation()
        e.preventDefault()

        fileDrag.classList.remove("dragenter")
    }, false)

    fileDrag.addEventListener("drop", (e) => {
        e.stopPropagation()
        e.preventDefault()
        fileDrag.classList.remove("dragenter")

        fileList = e.dataTransfer.files

        handleFiles(fileList);
    }, false)
}


var handleFiles = (files) => {

    let list = document.getElementById("list")
    let imageType = /^image\//;

    for (let file of files) {

        let li = document.createElement("li")
        let thumbWrapper = document.createElement("div")
        
        // remove folders
        if (file.type == "") {
            continue
        }
        // check if the file type is image
        else if (imageType.test(file.type)) {

            let img = document.createElement("img")
            img.file = file

            thumbWrapper.appendChild(img)

            // read image content
            let reader = new FileReader()
            reader.readAsDataURL(file)

            reader.onload = ((aImg) => {

                return (e) => {
                    aImg.src = e.target.result
                }

            })(img)
        }
        // other file types
        else {
            let divThumb = document.createElement("div")
            divThumb.classList.add("thumb-ext")
            divThumb.innerText = file.name.split('.').pop().toUpperCase();
            thumbWrapper.appendChild(divThumb)
        }

        thumbWrapper.classList.add("thumb-wrapper")
        li.appendChild(thumbWrapper)

        let divInfo = document.createElement("div")
        let divName = document.createElement("div")
        let divSize = document.createElement("div")
        let divLastModified = document.createElement("div")

        divName.innerText = file.name
        divSize.innerText = `Size: ${file.size} bytes`
        
        // divLastModified.innerText = `Last modified date: ${file.lastModifiedDate}`
        // divInfo.appendChild(divLastModified)

        divInfo.classList.add("file-info")
        divInfo.appendChild(divName)
        divInfo.appendChild(divSize)
        li.appendChild(divInfo)

        list.appendChild(li)


    }


}