export default class common {
     /*static getImgUrl(pet) {
         require('../../assets/logo.png')
        return images('./' + pet + ".png")
     }*/

    static getConfig(){
    }

    static checkPerm(auth, location){
        if(!auth.isAdmin){
            window.location.replace(location);
        }
    }


}
