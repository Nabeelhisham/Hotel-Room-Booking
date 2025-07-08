
let features_section_form = document.getElementById('features_section_form');
let facilities_section_form = document.getElementById('facilities_section_form');

features_section_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_feature();
});

function add_feature() {
    let data = new FormData();
    data.append('name',features_section_form.elements['feature_name'].value);
    data.append('add_feature','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);

    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById('features-section');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1) {
            alert('success','New Feature added Succesfully!');
            features_section_form.elements['feature_name'].value='';
            get_features_data();
        }
        else {
            alert('error','Server Down!');
            
        }

    }
    xhr.send(data);
}

function get_features_data() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('features_data').innerHTML = this.responseText;
    }

    xhr.send('get_features_data');

}

function del_feature_data(val) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    xhr.onload = function() {

        if(this.responseText == 1) {
            alert('success','Feature removed Succesfully!');
            get_features_data();
        }
        else if(this.responseText == 'room_added') {
            alert('error','Feature is already added in room');
        }

        else {
            alert('error','Server Down!');
        }
    }
    xhr.send('del_feature_data='+val);
}

facilities_section_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_facility();
});

function add_facility() {
    let data = new FormData();
    data.append('name',facilities_section_form.elements['facility_name'].value);
    data.append('icon',facilities_section_form.elements['facility_icon'].files[0]);
    data.append('description',facilities_section_form.elements['facility_description'].value);
    data.append('add_facility','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);

    xhr.onload = function() {
        console.log(this.responseText);
        var myModal = document.getElementById('facilities-section');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 'inv_img') {
            alert('error','Only SVG images are allowed!');
        }
        else if(this.responseText == 'inv_size') {
            alert('error','Icon Size should be less than 1MB!');
        }

        else if(this.responseText == 'upd_failed') {
            alert('error','Server Down. Icon upload failed!');
        }
        else {
            alert('success','New Facility added Succesfully!');
            facilities_section_form.reset();
            get_facilities_data();
        }

    }
    xhr.send(data);
}

function get_facilities_data() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('facilities_data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities_data');
}

function del_facility_data(val) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST","admin_ajax/features_facilities_crud.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    xhr.onload = function() {

        if(this.responseText == 1) {
            alert('success','Facility removed Succesfully!');
            get_facilities_data();
        }
        else if(this.responseText == 'room_added') {
            alert('error','Facility is already added in room');
        }

        else {
            alert('error','Server Down!');
        }
    }
    xhr.send('del_facility_data='+val);
}


window.onload = function() {
    get_features_data();
    get_facilities_data();
}

