/**@abstract
 * This function is called when the checkbox is checked or unchecked and changes to darkmode depending on its status
 * 
 */
 function darkmode(){
    var element = document.body;
    if(document.getElementById('slider').checked){
        element.className = "dark-mode";
        document.getElementById("ahrefI").className = "a-style-dark";
        document.getElementById("ahrefF").className = "a-style-dark"; 
    }
    else{
        element.className = "light-mode";
        document.getElementById("ahrefI").className = "a-style";
        document.getElementById("ahrefF").className = "a-style";
    }

}