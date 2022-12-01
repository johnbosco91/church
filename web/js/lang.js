$(function (){
    const selectLang = document.getElementById('languages');
    // When a new <option> is selected
    selectLang.addEventListener('change', () => {
        const lang = selectLang.value;
        // const lang = selectLang.value();
        $.post('index.php?r=site/language', {'lang':lang}, function(data){
            location.reload();
        });
    });
});