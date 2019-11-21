//function logout(){
//   href = "./logout.php";
//    ret = confirm("ログアウトします。\nよろしいですか？");
//    if(ret===true){
//        location.href = href;
//    }
//}

function open_serch_client(){
    href = "../serch/client.php";
    window.open(href, "企業コード検索", "scrollbars=yes");
    
}

function serch_client_write(c1){
    opener.contract1.clientid.value = c1;
    window.close();
}

function open_serch_address(){
    href = "../serch/address.php";
    window.open(href, "契約者コード検索", "scrollbars=yes");
    
}

function skip_create_client(){
    href = "../create/create_client.php";
    window.open(href,"新規作成:企業","scrollbars=yes");
}

function open_blankdata(){
    $(function(){
        $('#none_data').modal('show');
    });
}

function confirm_create(){
    document.confirm.name.value = create_cl.name.value;
    document.confirm.department.value = create_cl.department.value;
    document.confirm.postalcode.value = create_cl.postalcode.value;
    document.confirm.pref.value = create_cl.pref.value;
    document.confirm.city.value = create_cl.city.value;
    document.confirm.address.value = create_cl.address.value;
    document.confirm.address2.value = create_cl.address2.value;
    document.confirm.tel1.value = create_cl.tel1.value;
    document.confirm.tel1_category.value = create_cl.tel1_category.value;
    document.confirm.tel2.value = create_cl.tel2.value;
    document.confirm.tel2_category.value = create_cl.tel2_category.value;
    document.confirm.category.value = create_cl.category.value;
    document.confirm.memo.value = create_cl.memo.value;
    $(function(){
        $('#confirm_m').modal('show');
    });
    
}