const app = new Vue({
    el:'#app',
    data(){
        return{
            id:'',
            pass:'',
            credit:''
        };
    },
    computed:{
        isInValidId(){
            if(this.id.match(/[a-zA-Z0-9]{8}/)){
                if(this.id.match(/[a-zA-Z0-9]{9}/)){
                    return true;
                }else{
                    if(this.id.match(/[あ-んァ-ヾA-Z-ー*@/()$#&!%<>亜-熙０-９]/)){
                        return true;
                    }else {
                        if(this.id.match(/[a-zA-Z]/)&&this.id.match(/[0-9]/)) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }
            }else{
                return true;
            }
        },
        isInValidPass(){
            if(this.pass.match(/[0-9]{4}/)){
                if(this.pass.match(/[0-9]{5}/)){
                    return true;
                }else{
                    if(this.pass.match(/[あ-んa-zA-Zァ-ヾA-Z-ー*@/()$#&!%<>亜-熙０-９]/)){
                        return true;
                    }else {
                        return false;
                    }
                }
            }else{
                return true;
            }
        },
        isInValidCredit(){
            if(this.credit.match(/[0-9]{16}/)){
                if(this.credit.match(/[0-9]{17}/)){
                    return true;
                }else{
                    if(this.credit.match(/[-]/)){
                        return true;
                    }else {
                        return false;
                    }
                }
            }else{
                return true;
            }
        }
    }
});