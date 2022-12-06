$(function (){
    const selectLang = document.getElementById('languages');
    selectLang.addEventListener('change', () => {
        const lang = selectLang.value;
        let date = new Date();
        date.setDate(date.getDate()+30);
        document.cookie = 'lang='+lang+'; expires="+date.toUTCString()+"; path=/'
        location.reload();

        // $.post('index.php?r=church/language', {'lang':lang}, function(data){
        //
        //     alert( "Data Loaded: " + data );
        //     location.reload();
        // });


    });
});