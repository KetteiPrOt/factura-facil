export default () => ({

    without_taxes: [],
    subtotal_15: [],
    subtotal_5: [],
    subtotal_0: [],
    subtotal_no_vat: [],
    subtotal_vat_exempt: [],
    tax_15: [],
    tax_5: [],

    reset(){
        this.without_taxes = [];
        this.subtotal_15 = [];
        this.subtotal_5 = [];
        this.subtotal_0 = [];
        this.subtotal_no_vat = [];
        this.subtotal_vat_exempt = [];
        this.tax_15 = [];
        this.tax_5 = [];
    },

    productTotal(key, product, iva_code){
        if( ! product ) return 0;
        let total = parseFloat((product.amount * product.price) - product.discount);
        if(total < 0) total = 0;
        this.without_taxes[key] = total;
        if(iva_code == 4){
            this.subtotal_15[key] = total;
            this.tax_15[key] = total * 0.15;
        }
        if(iva_code == 5){
            this.subtotal_5[key] = total;
            this.tax_5[key] = total * 0.05;
        }
        if(iva_code == 0)
            this.subtotal_0[key] = total;
        if(iva_code == 6)
            this.subtotal_no_vat[key] = total;
        if(iva_code == 7)
            this.subtotal_vat_exempt[key] = total;
        return total;
    },

    clearProduct(key, iva_code){
        delete this.without_taxes[key];
        if(iva_code == 4){
            delete this.subtotal_15[key];
            delete this.tax_15[key];
        }
        if(iva_code == 5){
            delete this.subtotal_5[key];
            delete this.tax_5[key];
        }
        if(iva_code == 0)
            delete this.subtotal_0[key];
        if(iva_code == 6)
            delete this.subtotal_no_vat[key];
        if(iva_code == 7)
            delete this.subtotal_vat_exempt[key];
    },

    total(){
        return (
            parseFloat(this.sum('without_taxes')) 
            + parseFloat(this.sum('tax_15')) 
            + parseFloat(this.sum('tax_5'))
        ).toFixed(2);
    },

    sum(property){
        let total = 0;
        for(let i in this[property]){
            total += this[property][i];
        }
        if(total < 0) total = 0;
        return total.toFixed(2);
    }
})