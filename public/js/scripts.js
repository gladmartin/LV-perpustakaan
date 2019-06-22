$('input[type="file"]').change(function(e){
    let fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
});

function initNotify(text, type='info', classCss='dark', title = 'Info'){
    let config = {
        title,
        text,
        type,
        styling: 'bootstrap3',
        addclass:classCss
    }
    notif = new PNotify(config)
} 
async function hapusData(url, ini){
    try {
        loadingOn();
        const response = await axios.delete(siteUrl(url));
        loadingOff();
        const {msg} = response.data;
        if (!response.data.status) {
            return alertify.alert('Error',msg,
                function(){}
            );
        }
        ini.parent().parent().remove();
        initNotify(msg);
    } catch (error) {
        loadingOff();
        alertify.alert('Error',error,
            function(){}
        );
        return;
    }
}
clearErrorInput = (element) => {
    if (element.length == 1) {
        element.removeClass('parsley-error');
    } else {
        $.each(element, function(i, ele) {
            ele.removeClass('parsley-error');
        })
    }
    $('.errorInput').html('');
}
async function sendAxios(data, url, method = 'GET') {
    try {
        loadingOn();
        const response = await axios({
            method,
            url,
            data
        })
        loadingOff();
        return response;
    } catch (error) {
        loadingOff();
        alertify.alert('Error',error,
            function(){}
        );
    }
}
$('select').select2({
    placeholder: '-- Pilih option--'
});
loadingOn = () => {
    $('.load').addClass('loading');
}
loadingOff = () => {
    $('.load').removeClass('loading');
}
let config = {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
}
ClassicEditor
.create( document.querySelector( '#deskripsi' ), config )
    .then( editor => {
        console.log( editor );
} )
.catch( error => {
        // console.error( error );
} );