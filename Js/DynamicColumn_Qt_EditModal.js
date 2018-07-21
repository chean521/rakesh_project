var qt_edit_counter = 0;
var qt_edit_max_col = 10;
var qt_edit_taxes = [];
var qt_edit_currencies = [];
var qt_edit_wins = null;

$(document).ready(function (e){
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var data = JSON.parse(this.responseText);
            
            data.forEach(function(c){
                qt_edit_taxes.push(c);
            });
        }
    };
    
    xmlhttp.open("POST", "/WBServices/GetTaxRate_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(); 
    
    var xmlhttp2 = new XMLHttpRequest();
    
    xmlhttp2.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var data = JSON.parse(this.responseText);
            
            data.forEach(function(c){
                qt_edit_currencies.push(c);
            });
        }
    };
    
    xmlhttp2.open("POST", "/WBServices/GetCurrencyRate_Resp.php", true);
    xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp2.send(); 
});

function qt_edit_AddColumn(pid){
    
    if(qt_edit_counter < 10){
        qt_edit_counter+=1;
        
        var html_string = "<tr>";
        html_string += '<td><div class="input-group"><input type="text" class="form-control" readonly /><div class="input-group-btn">'+
            '<button type="button" class="btn btn-outline-primary" onclick="qt_edit_ProductId_PopUpSelect('+pid+',this);"><i class="glyphicon glyphicon-search" ></i></button></div></div></td>';
        html_string += '<td><input type="number" class="form-control" min="1" max="200" oninput="qt_edit_Qty_OnInputCount(this,this.value);qt_edit_TotalUpAmt();"  /></td>';
        html_string += '<td><input type="text" class="form-control" readonly/></td>';
        html_string += '<td><input type="text" class="form-control" readonly /></td>';
        html_string += '<td><input type="text" class="form-control" readonly /></td>';
        html_string += '<td><button type="button" onclick="qt_edit_deleteRow(this)" class="btn btn-outline-danger btn-sm" style="border: 0;"><i class="glyphicon glyphicon-remove"></i></button></td>';
        html_string += "</tr>";
        
        $('#qt_edit_Desc_Container tbody').append(html_string);
        $('#qt_edit_count').html(qt_edit_counter);
    } 
    
}

function qt_edit_deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("qt_edit_Desc_Container").deleteRow(i);
    qt_edit_counter -= 1;
    $('#qt_edit_count').html(qt_edit_counter);
}

function qt_edit_ProductId_PopUpSelect(pid, pos){
    var line = pos.closest("tr").rowIndex;
    if(qt_edit_wins === null) qt_edit_wins = window.open("CustProductSelect_Pop_Edit.php?pid="+pid+"&ind="+line,"_blank", "width=900,height=540,scrollbars=1,left=300,top=50");
    else qt_edit_wins.focus();
}

function qt_edit_GetProducts(Prod_Id, Pid, line, rest_data){
    var x = document.getElementById("qt_edit_Desc_Container").rows[line].cells[0].querySelector('input');
    x.value = Prod_Id;
    
    var units = document.getElementById("qt_edit_Desc_Container").rows[line].cells[2].querySelector('input');
    units.value = rest_data[0];
    
    document.getElementById("qt_edit_Desc_Container").rows[line].cells[4].querySelector('input').value = rest_data[1];

    var qtys = document.getElementById("qt_edit_Desc_Container").rows[line].cells[1].querySelector('input');
    qt_edit_wins = null;

    if(qtys.value !== null && qtys.value !== ""){
        document.getElementById("qt_edit_Desc_Container").rows[line].cells[3].querySelector('input').value = parseInt(qtys.value) * parseFloat(units.value);
        qt_edit_TotalUpAmt();
    }
}

function SetClosedArgs(){
    qt_edit_wins = null;
}

function qt_edit_Qty_OnInputCount(row, values){
    var index = row.closest("tr").rowIndex;
    
    var UnitPrice = document.getElementById("qt_edit_Desc_Container").rows[index].cells[2].querySelector('input').value;
    document.getElementById("qt_edit_Desc_Container").rows[index].cells[3].querySelector('input').value = parseInt(UnitPrice) * parseFloat(values);
}

function qt_edit_TotalUpAmt(){
    var total_conversion = 0.00;
    var total_taxed = 0.00;
    var grand_total_no_taxed = 0.00;
    var grand_total_yes_taxed = 0.00;
    var Conv_Rate = 0.0000;
    
    var row_size = document.getElementById("qt_edit_Desc_Container").rows.length;
    var x = document.getElementById("Qt_Edit_Currency");
    var curr_conv = x.options[x.selectedIndex].value;
    
    for(var i=1; i<row_size; i++){
        var amt = parseFloat(document.getElementById("qt_edit_Desc_Container").rows[i].cells[3].querySelector('input').value);
        var tax = document.getElementById("qt_edit_Desc_Container").rows[i].cells[4].querySelector('input').value;
        var tax_val = 0.00;
        
        if(isNaN(amt)) continue;
        
        grand_total_no_taxed += amt;
        
        for(var j=0; j<qt_edit_taxes.length; j++){
            if(qt_edit_taxes[j].TaxCode === tax){
                tax_val = parseFloat(qt_edit_taxes[j].TaxRate);
                break;
            }
        }
        
        total_taxed += (amt * tax_val);
        grand_total_yes_taxed += (amt * (1.00 + tax_val));
    }
    
    for(var i=0; i<qt_edit_currencies.length; i++){
        if(curr_conv === qt_edit_currencies[i]["Sign"]){
            Conv_Rate = parseFloat(qt_edit_currencies[i]["ConvertRate"]);
            break;
        }
    }
    
    total_conversion = (grand_total_yes_taxed * Conv_Rate);
    
    $('#qt_edit_convert_grand_amt').html(total_conversion.toFixed(2));
    $('#qt_edit_tax_charged').html(total_taxed.toFixed(2));
    $('#qt_edit_grand_total').html(grand_total_yes_taxed.toFixed(2));
}