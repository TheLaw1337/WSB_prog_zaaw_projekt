// dodawanie elementu do listy dodanych plików
filepicker.addEventListener('change', function(e){
    let output = document.getElementById("labelFilepicker");
    let files = e.target.files;

    for (let i=0; i<files.length; i++) 
    {
        let item = document.createElement("li");
        item.innerHTML = "<span class='badge badge-primary'>"+files[i].name+"</span>";
        output.appendChild(item);
    };
}, false);


// aktywacja okna modalnego do usuwania eventu
function modal_delete(id)
{
    document.getElementById("delete_button").value = id;
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus');
    })
}