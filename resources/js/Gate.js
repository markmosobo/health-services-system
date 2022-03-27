export default class Gate{
    constructor(user){
        this.user = user;
    }

    isSuperAdmin(){
        return this.user.role === 'superadmin';
    }

    isAdmin(){
        return this.user.role === 'admin';
    }

    isDoc(){
        return this.user.role === 'doctor';
    }

    isNurse(){
        return this.user.role === 'nurse';
    }

    isAccountant(){
        return this.user.role === 'accountant';
    }

    isPharm(){
        return this.user.role === 'pharmacist';
    }

    isStaff(){
        return this.user.role === 'staff';
    }

    isSuperAdminOrAdmin(){
        if(this.user.role === 'superadmin' || this.user.role === 'admin'){
            return true;
        }
    }

    isSuperAdminOrAdminOrAccountant(){
        if(this.user.role === 'superadmin' || this.user.role === 'admin' ||
        this.user.role === 'accountant'){
            return true;
        }
    }

    isSuperAdminOrAdminOrDocOrNurse(){
        if(this.user.role === 'superadmin' || this.user.role === 'admin' ||
        this.user.role === 'doctor' || this.user.role === 'nurse'){
            return true;
        }
    }

    isDocOrNurse(){
        if(this.user.role === 'doctor' || this.user.role === 'nurse'){
            return true;
        }
    }
}