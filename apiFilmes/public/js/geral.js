$(function(){
    
    $('#frTokenEmail').change(function(){
        
        var strPass = $('#frTokenEmail').val()
        strPass     = btoa(strPass);

        $('#frTokenEmail').val(strPass)
        
    })

    $('#frTokenBtn').click(function(){
        
        var strPass = $('#frTokenEmail').val()
        strPass     = btoa(strPass);

        setTimeout(function(){
            $('#frTokenEmail').val(strPass)
        },500)

        return true
        
    })

})


function copiarTexto(idElemento){
    try{
        
        var txtCopy = document.getElementById(idElemento)
        txtCopy.select()
        document.execCommand("Copy")
        
    }catch(e){
        console.error(e)
    }
}