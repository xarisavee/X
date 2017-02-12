function Formula1Calc(){
    //Here we get the total price by calling our function
    //Each function returns a number so by calling them we add the values they return together
    var Rate = 0;
    var PresentValue = 0;
    var Terms = 0;
    var LoanInstallment = 0;

    var Formula1Form = document.forms["Formula2Form"];

    Terms = Formula1Form.elements['f2_n'].value;
    PresentValue = Formula1Form.elements['f2_pv'].value;
    Rate = Formula1Form.elements['f2_r'].value;

    Rate = Rate / 100;


    // r(PV) / 1-(1+r)^n;
    // LoanInstallment = (Rate*PresentValue) / (1-(Math.pow((1+Rate), -Math.abs(Terms)));

    LoanInstallment = -Math.abs(Terms);
    //display the result
    var divobj = document.getElementById('Formula1Output');
    divobj.style.display='block';
    divobj.innerHTML = "Your loan installment per term: "+LoanInstallment;

}

function hideTotal(){
    var divobj = document.getElementById('Formula1Output');
    divobj.style.display='none';
}