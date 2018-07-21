var counter = 0;
var max_col = 10;
var taxes = [];
var currencies = [];
var wins = null;

$(document).ready(function (e){
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var data = JSON.parse(this.responseText);
            
            data.forEach(function(c){
                taxes.push(c);
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
                currencies.push(c);
            });
        }
    };
    
    xmlhttp2.open("POST", "/WBServices/GetCurrencyRate_Resp.php", true);
    xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp2.send(); 
});

function AddColumn(pid){
    
    if(counter < 10){
        counter+=1;
        
        var html_string = "<tr>";
        html_string += '<td><div class="input-group"><input type="text" class="form-control" readonly /><div class="input-group-btn">'+
            '<button type="button" class="btn btn-outline-primary" onclick="ProductId_PopUpSelect('+pid+',this);"><i class="glyphicon glyphicon-search" ></i></button></div></div></td>';
        html_string += '<td><input type="number" class="form-control" min="1" max="200" oninput="Qty_OnInputCount(this,this.value);TotalUpAmt();" onfocus="ReleaseWhite(this);" /></td>';
        html_string += '<td><input type="text" class="form-control" readonly/></td>';
        html_string += '<td><input type="text" class="form-control" readonly /></td>';
        html_string += '<td><input type="text" class="form-control" readonly /></td>';
        html_string += '<td><button type="button" onclick="deleteRow(this)" class="btn btn-outline-danger btn-sm" style="border: 0;"><i class="glyphicon glyphicon-remove"></i></button></td>';
        html_string += "</tr>";
        
        $('#Desc_Container tbody').append(html_string);
        $('#count').html(counter);
    } 
    
}

function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("Desc_Container").deleteRow(i);
    counter -= 1;
    $('#count').html(counter);
}

function ProductId_PopUpSelect(pid, pos){
    var line = pos.closest("tr").rowIndex;
    if(wins === null) wins = window.open("CustProductSelect_Pop.php?pid="+pid+"&ind="+line,"_blank", "width=900,height=540,scrollbars=1,left=300,top=50");
    else wins.focus();
}

function GetProducts(Prod_Id, Pid, line, rest_data){
    var x = document.getElementById("Desc_Container").rows[line].cells[0].querySelector('input');
    x.value = Prod_Id;
    
    var units = document.getElementById("Desc_Container").rows[line].cells[2].querySelector('input');
    units.value = rest_data[0];
    
    document.getElementById("Desc_Container").rows[line].cells[4].querySelector('input').value = rest_data[1];

    var qtys = document.getElementById("Desc_Container").rows[line].cells[1].querySelector('input');
    ReleaseWhite(x);
    wins = null;

    if(qtys.value !== null && qtys.value !== ""){
        document.getElementById("Desc_Container").rows[line].cells[3].querySelector('input').value = parseInt(qtys.value) * parseFloat(units.value);
        TotalUpAmt();
    }
}

function SetClosedArgs(){
    wins = null;
}

function Qty_OnInputCount(row, values){
    var index = row.closest("tr").rowIndex;
    
    var UnitPrice = document.getElementById("Desc_Container").rows[index].cells[2].querySelector('input').value;
    document.getElementById("Desc_Container").rows[index].cells[3].querySelector('input').value = parseInt(UnitPrice) * parseFloat(values);
}

function TotalUpAmt(){
    var total_conversion = 0.00;
    var total_taxed = 0.00;
    var grand_total_no_taxed = 0.00;
    var grand_total_yes_taxed = 0.00;
    var Conv_Rate = 0.0000;
    
    var row_size = document.getElementById("Desc_Container").rows.length;
    var x = document.getElementById("Currency");
    var curr_conv = x.options[x.selectedIndex].value;
    
    for(var i=1; i<row_size; i++){
        var amt = parseFloat(document.getElementById("Desc_Container").rows[i].cells[3].querySelector('input').value);
        var tax = document.getElementById("Desc_Container").rows[i].cells[4].querySelector('input').value;
        var tax_val = 0.00;
        
        if(isNaN(amt)) continue;
        
        grand_total_no_taxed += amt;
        
        for(var j=0; j<taxes.length; j++){
            if(taxes[j].TaxCode === tax){
                tax_val = parseFloat(taxes[j].TaxRate);
                break;
            }
        }
        
        total_taxed += (amt * tax_val);
        grand_total_yes_taxed += (amt * (1.00 + tax_val));
    }
    
    for(var i=0; i<currencies.length; i++){
        if(curr_conv === currencies[i]["Sign"]){
            Conv_Rate = parseFloat(currencies[i]["ConvertRate"]);
            break;
        }
    }
    
    total_conversion = (grand_total_yes_taxed * Conv_Rate);
    
    $('#convert_grand_amt').html(total_conversion.toFixed(2));
    $('#tax_charged').html(total_taxed.toFixed(2));
    $('#grand_total').html(grand_total_yes_taxed.toFixed(2));
}