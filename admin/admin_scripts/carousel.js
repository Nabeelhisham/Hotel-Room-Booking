
    let carousel_section_form = document.getElementById('carousel_section_form');
    let carousel_pic_inp = document.getElementById('carousel_pic_inp');


    carousel_section_form.addEventListener('submit',function(e){
        e.preventDefault();
        add_carousel_img();
    });

    function add_carousel_img() {
        let data = new FormData();
        data.append('picture',carousel_pic_inp.files[0]);
        data.append('add_carousel_img','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/carousel_crud.php",true);

        xhr.onload = function() {
            console.log(this.responseText);
            var myModal = document.getElementById('carousel-section');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            if(this.responseText == 'inv_img') {
                alert('error','Only JPG and PNG images are allowed!');
            }
            else if(this.responseText == 'inv_size') {
                alert('error','Image Size should be less than 2MB!');
            }

            else if(this.responseText == 'upd_failed') {
                alert('error','Server Down. Image upload failed!');
            }
            else {
                alert('success','New Image added Succesfully!');
                carousel_pic_inp.value = '';
                get_carousel_img();
            }

        }
        xhr.send(data);
    }

    function get_carousel_img() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/carousel_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            document.getElementById('carousel_data').innerHTML = this.responseText;
        }

        xhr.send('get_carousel_img');

    }

    function del_carousel_img(val) {

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/carousel_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {

            if(this.responseText == 1) {
                alert('success','Image removed Succesfully!');
                get_carousel_img();
            }
            else {
                alert('error','Server Down!');
            }
        }
        xhr.send('del_carousel_img='+val);
    }

    window.onload = function() {
        get_carousel_img();
    }
