window.addEventListener('load', function(){
    'use strict';

    const l_form = document.getElementById('orderForm');
    const l_checkboxes = l_form.querySelectorAll('input[data-price][type=checkbox]');
    const l_radioboxes = l_form.querySelectorAll('input[data-price][type=radio]');
    const l_submitButton = l_form.querySelector('input[name=submit]');
    const l_selectCustomerType = l_form.querySelector('select[name=customerType]');
    const l_termsCheckBox = l_form.querySelector('input[name=termsChkbx]'),
        l_terms = document.getElementById('termsText'),
        l_style = l_terms.getAttribute('style');

    let l_totalPrice = 0;

    /**
     * Calculates the collection price
     * @returns {number}    collection price
     */
    function calculateCollectionPrice(){
        let l_collectionPrice = 0;

        l_radioboxes.forEach(t_radioboxes => {
           if(t_radioboxes.checked){
               l_collectionPrice += parseFloat(t_radioboxes.getAttribute('data-price'));
           }
        });

        return l_collectionPrice;
    }

    /**
     * Calculates the total price for selected records and collection method.
     */
    function calculateTotalPrice(){
        l_totalPrice = 0;

        l_checkboxes.forEach(t_checkbox =>{
            if(t_checkbox.checked){
                l_totalPrice += parseFloat(t_checkbox.getAttribute('data-price'));
            }
        });

        if(l_totalPrice != 0){
            l_totalPrice += calculateCollectionPrice();
        }
        l_form.total.value = l_totalPrice.toFixed(2);
    }//end of function

    /**
     * Adds event listen to terms check box. If terms checkbox is checked, change it style and enable submit button
     * otherwise change style to default and disable submit button.
     */
    l_termsCheckBox.addEventListener('click', () => {
        if(l_termsCheckBox.checked){
            l_terms.style = "color: black; font-weight: normal";
            l_submitButton.disabled = false;
        }else{
            l_terms.style = l_style;
            l_submitButton.disabled = true;
        }
    });//end of function

    /**
     * Assigns on change event listen to customer type select box, and changes visibility of divs
     * depending on which option has been selected.
     */
     l_selectCustomerType.addEventListener('change', () => {
         const t_customerDetailsDiv = document.getElementById('retCustDetails');
         const t_tradeCustomerDetailsDiv = document.getElementById('tradeCustDetails');
         let t_customerValue = l_selectCustomerType.options[l_selectCustomerType.selectedIndex].value;

         if(t_customerValue === 'ret'){
             t_customerDetailsDiv.style.visibility = 'visible';
             t_tradeCustomerDetailsDiv.style.visibility = 'hidden';
         }else if(t_customerValue === 'trd'){
             t_customerDetailsDiv.style.visibility = 'hidden';
             t_tradeCustomerDetailsDiv.style.visibility = 'visible';
         }
     });//end of function

    /**
     * Loops through all checkboxes and assigns them an event listener.
     */
    l_checkboxes.forEach(t_checkboxes => {
       t_checkboxes.addEventListener('click', calculateTotalPrice, false);
    });

    /**
     * Loops through all radioboxes and assigns them an event listener.
     */
     l_radioboxes.forEach(t_radioboxes => {
        t_radioboxes.addEventListener('click', calculateTotalPrice, false);
     });

    /**
     * Performs checks to ensure record is selected, and text fields are not empty.
     */
    l_submitButton.addEventListener('click', (event) =>{
        let l_failed = false;
        const l_customerForename = l_form.querySelector('input[name=forename]');
        const l_customerSurname = l_form.querySelector('input[name=surname]');
        const l_companyName = l_form.querySelector('input[name=companyName]');

        if(l_customerForename.value === "" && l_customerSurname.value === "" && l_companyName.value === ""){
            l_failed = true;
            alert("You need to provide forename and surname or company name!");
        }

        if(l_totalPrice === 0){
            l_failed = true;
            alert("You need to select a record to purchase!");
        }

        if(l_failed){
            event.preventDefault()
        }
    });

    l_form.total.value = '0.00';
    l_submitButton.disabled = true;
});