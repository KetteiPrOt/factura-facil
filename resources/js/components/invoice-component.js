export default () => ({

    without_taxes: [],
    subtotal_15: [],
    subtotal_5: [],
    tax_15: [],
    tax_5: [],

    productTotal(key, product, iva){
        if( ! product ) return 0;
        let total = parseFloat((product.amount * product.price) - product.discount);
        this.without_taxes[key] = total;
        if(iva == 15){
            this.subtotal_15[key] = total;
            this.tax_15[key] = total * 0.15;
        }
        if(iva == 5){
            this.subtotal_5[key] = total;
            this.tax_5[key] = total * 0.05;
        };
        if(total < 0) total = 0;
        return total;
    },

    clearProduct(key, iva){
        delete this.without_taxes[key];
        if(iva == 15){
            delete this.subtotal_15[key];
            delete this.tax_15[key];
        }
        if(iva == 5){
            delete this.subtotal_5[key];
            delete this.tax_5[key];
        };
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