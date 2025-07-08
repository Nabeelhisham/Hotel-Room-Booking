    let general_data , contacts_data;
    let general_settings_form = document.getElementById('general_settings_form');
    let site_title_inp = document.getElementById('site_title_inp');
    let site_about_inp = document.getElementById('site_about_inp');
    let contacts_section_form = document.getElementById('contacts_section_form');

    let team_section_form = document.getElementById('team_section_form');
    let team_member_name_inp = document.getElementById('team_member_name_inp');
    let team_member_pic_inp = document.getElementById('team_member_pic_inp');

    function get_general() {

        let site_title = document.getElementById('site_title');
        let site_about = document.getElementById('site_about');

        let shutdown_toggle = document.getElementById('shutdown-toggle');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            general_data = JSON.parse(this.responseText);

            site_title.innerText = general_data.site_title;
            site_about.innerText = general_data.site_about;

            site_title_inp.value = general_data.site_title;
            site_about_inp.value = general_data.site_about;

            if(general_data.shutdown == 0) {
                shutdown_toggle.checked = false;
                shutdown_toggle.value = 0;
            }
            else {
                shutdown_toggle.checked = true;
                shutdown_toggle.value = 1;

            }
        }

        xhr.send('get_general');
    }

    general_settings_form.addEventListener('submit',function(e) {
        e.preventDefault();
        update_general(site_title_inp.value,site_about_inp.value);
    });

    function update_general(site_title_val,site_about_val) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            var myModal = document.getElementById('general-s');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            if(this.responseText == 1) {
                alert('success','Data Updated Succesfully!');
                get_general();
            }
            else {
                alert('error','No Changes made in Data!');
            }
        }

        xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&update_general');

    }

    function update_shutdown(val) {        
        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            if(this.responseText == 1 && general_data.shutdown == 0) {
                alert('success','Site has been shutdown!');
            }
            else {
                alert('success','Shutdown mode off!');
            }
            get_general();
        }

        xhr.send('update_shutdown='+val);

    }

    function get_contacts() {

        let contacts_P =['cd_address','cd_map','phone_no_1','phone_no_2','cd_email','cd_fb','cd_insta','cd_tw'];
        let cd_iframe = document.getElementById('cd_iframe');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            contacts_data = JSON.parse(this.responseText);
            contacts_data = Object.values(contacts_data);

            for(i=0;i<contacts_P.length;i++){
                document.getElementById(contacts_P[i]).innerText = contacts_data[i+1];
            }
            cd_iframe.src = contacts_data[9];
            contacts_inp(contacts_data);

        }

        xhr.send('get_contacts');
    }

    function contacts_inp(data) {
        contacts_inp_id = ['cd_address_inp','cd_map_inp','phone_no_1_inp','phone_no_2_inp','cd_email_inp','cd_fb_inp','cd_insta_inp','cd_tw_inp','cd_iframe_inp'];

        for(i=0;i<contacts_inp_id.length;i++) {
            document.getElementById(contacts_inp_id[i]).value = data[i+1];
        }
    }

    contacts_section_form.addEventListener('submit',function(e) {
        e.preventDefault();
        update_contacts();
    });

    function update_contacts() {
        let index = ['cd_address','cd_map','phone_no_1','phone_no_2','cd_email','cd_fb','cd_insta','cd_tw','cd_iframe'];
        let contacts_inp_id = ['cd_address_inp','cd_map_inp','phone_no_1_inp','phone_no_2_inp','cd_email_inp','cd_fb_inp','cd_insta_inp','cd_tw_inp','cd_iframe_inp'];
        let data_str = "";

        for(i=0;i<index.length;i++) {
            data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
        }

        data_str += "update_contacts";

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            var myModal = document.getElementById('contacts-section');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            if(this.responseText == 1) {
                alert('success','Data Updated Succesfully!');
                get_contacts();
            }
            else {
                alert('error','No changes made in data!');
            }
        }

        xhr.send(data_str);

    }

    team_section_form.addEventListener('submit',function(e){
        e.preventDefault();
        add_team_member();
    });

    function add_team_member() {
        let data = new FormData();
        data.append('name',team_member_name_inp.value);
        data.append('picture',team_member_pic_inp.files[0]);
        data.append('add_team_member','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);

        xhr.onload = function() {
            console.log(this.responseText);
            var myModal = document.getElementById('team-section');
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
                alert('success','New Member added Succesfully!');
                team_member_name_inp.value = '';
                team_member_pic_inp.value = '';
                get_team_members();
            }

        }
        xhr.send(data);
    }

    function get_team_members() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            document.getElementById('team_data').innerHTML = this.responseText;
        }

        xhr.send('get_team_members');

    }

    function del_team_member(val) {

        let xhr = new XMLHttpRequest();
        xhr.open("POST","admin_ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        xhr.onload = function() {

            if(this.responseText == 1) {
                alert('success','Member removed Succesfully!');
                get_team_members();
            }
            else {
                alert('error','Serve Down!');
            }
        }



        xhr.send('del_team_member='+val);
    }

    window.onload = function() {
        get_general();
        get_contacts();
        get_team_members();
    }
