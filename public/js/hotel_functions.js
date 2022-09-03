//constants

const route_root='/';

function process422Errors(errors, fieldName, auth) {
    var first=true;
    var messages='';
    if(errors){
        errors.forEach(error => {
            if (first) {
                messages+='<h4 class="swal-color swal-h">'+fieldName+':</h4>';
                first=false;
            }
            if(auth){
                if(fieldName == 'E-Mail'){error=error.replace('email', 'E-Mail');}
                else if (fieldName == 'Contraseña'){error=error.replace('password', 'contraseña'); }
            }
            messages+='<p class="swal-color" >'+error+'</p>';
        });
        
        return messages;
        
    }
    return '';
}

function processAll422Errors(error_arrays){
    let errors = '';

    error_arrays.forEach((error_array)=>{
        errors += process422Errors(error_array.errors, error_array.field_name);
    });

    return errors;
}

//Mostly used to display the error messages
function displaySwal(message, success, confirm) {
    let params = {};
    params.title = "Errores encontrados, por favor verifique:";
    params.icon = 'warning';
    params.button = 'Volver a intentar';
    if(success){
        params.title = success.title;
        params.icon = success.icon;
        params.button = 'Continuar';
    }else if(confirm){
        return swal({
            title: 'ADVERTENCIA',
            content: {
                element: "p",
                attributes: {
                innerHTML: '<p class="swal-color" >'+message+'</p>'
                }
            },
            dangerMode:true,
            icon: params.icon,
            buttons:{   cancel: 'Cancerlar',
                        confirm:'Confirmar'},
            className: "alert",
        });
    }
    return swal({
        title: params.title,
        content: {
            element: "p",
            attributes: {
            innerHTML: '<p class="swal-color" >'+message+'</p>'
            }
        },
        dangerMode:params.dangerMode,
        icon: params.icon,
        button: params.button,
        className: "alert",
    });
}

function countryDataAjaxRequest(route, data, fieldName, parentSelectId, childSelectId) {
        
    $('#'+childSelectId+'Form').append('<p hidden class="w3-animate-zoom append-wait-icon mt-3"><i class="fa fa-spinner w3-spin "></i></p>');
    $('#'+childSelectId+'Form p').fadeIn();
    $.ajax({
        method: "POST",
        url: route,
        data: data,
        success: (serverResponse) => { 
            $('#'+childSelectId+'Form p').fadeOut();
            $('#'+childSelectId).empty();

            if(serverResponse.icon){  return swal(serverResponse);  }
            optionTags='';
            if(childSelectId=='region'){optionTags = '<option>Seleccione estado...</option>';}
            else {optionTags = '<option>Seleccione ciudad...</option>';}
            
            for( let i = 0; i < serverResponse.length; i++){
                optionTags += '<option>'+serverResponse[i]+'</option>';
            }
        },
        error: (serverResponse) => { 
            $('#'+childSelectId+'Form p').fadeOut();
            displaySwal(process422Errors(serverResponse.responseJSON.errors[parentSelectId], 
            fieldName));
        }//error
    })//ajax
    .done(function (){

        $('#'+childSelectId).append(optionTags);
        $('#'+childSelectId).attr('disabled', false);
        if(parentSelectId=='country'){ $('#locality').empty();
        $('#locality').append('<option>Seleccione ciudad...</option>');
        $('#locality').attr('disabled', true);}
    });//done
}//countryDataAjaxRequest

//populating country select box with on change event

function populateCountryFields(requestData){
    let data = {};
    requestData.forEach((request)=>{
        $('#'+request.tagId).on('change', function () {
            data[request.tagId] =  $(this).val();
            data['_token']=request._token;
            countryDataAjaxRequest(request.route, data, 
            request.fieldName, request.parentSelectId ,request.childSelectId);
        });//end
    });
}
function getCurrentDate(plusOneDay) {

    let currentDate = new Date();

    if (plusOneDay) { currentDate.setDate(currentDate.getDate() +1); }
    
    return currentDate.getDate()+'/'+(currentDate.getMonth()+1)
    +'/'+currentDate.getFullYear();
}

//
function attachDatePicker(selector, date_value) {
    $(selector).datetimepicker({
        timepicker:false,
        datepicker:true,
        format: 'd-m-Y',
        value: date_value,
        weeks:true,
        theme:'dark',
        mask: true,
        lang: 'es'
        });
}

function attachEvent(properties) { $(properties.tag).on(properties.event, properties.action);}

function setNavBtns() {
    let page='';
    if(my_pagination.prev_page_url){
        page=my_pagination.prev_page_url.substr(
        my_pagination.prev_page_url.indexOf("=")+1, my_pagination.prev_page_url.length-1 );
        console.log(page);
    }else { page=1;}

    $('#previous_page a').attr('route', page);

    if(my_pagination.next_page_url){
        page=my_pagination.next_page_url.substr(
        my_pagination.next_page_url.indexOf("=")+1, my_pagination.next_page_url.length-1 );
        console.log(page);
    }else { page=my_pagination.last_page;}

    $('#next_page a').attr('route', page);
}
function setNavBtnEvents(properties) {
    $('.page_navigation').on('click', function (e) {
        console.log('route',e.target.getAttribute('route'));
        refreshTable({
            route: properties.route,
            entity:properties.entity,
            populateTable: populateUserPeopleTable, 
            tbody_id: properties.tbody_id,
            modal_id: properties.modal_id,
            page: e.target.getAttribute('route')
        });
    });
}

function setPagination(properties){ 
    $('.dynamic_btn').remove();

    let first_page='', last_page='';

    if((my_pagination.current_page - 2) <1){first_page=1;}
    else { first_page=my_pagination.current_page - 2;}

    if(my_pagination.last_page<5){
        last_page=my_pagination.last_page;
    }else {  
        if(first_page==1){ last_page=first_page+ 4; }
        else if((my_pagination.current_page + 2)>my_pagination.last_page)
        { last_page=my_pagination.last_page;}
        else{ last_page=my_pagination.current_page + 2;   }  
    }
    for (let i = first_page; i <= last_page; i++) { 
        
        var tag_classes='hotel-item';
        
        if(properties.is_admin_panel){
            tag_classes='';
            console.log('pagination', i, my_pagination.current_page);
            if(i==my_pagination.current_page){ tag_classes+=' active'; }
            $('#next_page').before(
                '<li id="item'+i+'"  class="paginate_button page-item dynamic_btn w3-animate-zoom '+tag_classes+'"><a class="page-link" href="#">'+i+'</a></li>'
            );
        }
        else{
            if(i==my_pagination.current_page){ tag_classes+=' active-item'; }
            $('#next_page').before(
                '<li id="item'+i+'"  class="page-item dynamic_btn w3-animate-zoom"><a class="page-link '+tag_classes+'" href="#">'+i+'</a></li>'
            );
        }

       attachEvent({
            tag:'#item'+i + ' a', event:'click',
            action:function (e) {
                // let event_function=populateUserPeopleTable;
                // if(properties.populateTable){ event_function=properties.populateTable; }
                refreshTable({
                    route: properties.route,
                    entity:properties.entity,
                    populateTable: properties.populateTable, 
                    tbody_id: properties.tbody_id,
                    modal_id: properties.modal_id,
                    page:i
                });
            }
        });
    }     
}
var my_pagination;
function refreshTable(properties) {
    if(!properties.route){ return 0; }
    $.ajax( {
        method: "GET",
        url: properties.route,
        data: {page:properties.page},
        success: (serverResponse) => { console.log(serverResponse);
           my_pagination=serverResponse[properties.entity];
           setNavBtns();
            if(serverResponse[properties.entity]['total'] < 1){
                displaySwal(properties.no_row_message);  
            }
            
            properties.populateTable(
                serverResponse[properties.entity]['data'],
                {
                    tbody_id: properties.tbody_id,
                    per_page: serverResponse[properties.entity]['per_page'],
                    modal_id:serverResponse[properties.entity]['modal_id'],
                    relationships: serverResponse.relationship_types,
                    route_entity: serverResponse.route_entity
                }
            );
            
            setPagination({
                route: properties.route,
                tbody_id: properties.tbody_id,
                page: properties.page,
                entity: properties.entity,
                populateTable:  properties.populateTable,
                is_admin_panel: properties.is_admin_panel
            });

            if(properties.modal_id){  $(properties.modal_id).modal('hide');  }
        },
        error: (serverResponse) => { console.log(serverResponse);
          displaySwal('Hubo un error con su petición, intente nuevamente.')
          .then((value)=>{location.href='/'});   }//error
        });
}

