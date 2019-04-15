( function ($) {
    
    console.log(eventsArray);


    class Slideshow {
        constructor(){
            this.eventsArray = eventsArray;
            
        }
        


        formSingleCardsArray(){
            let card = "";
            for(let i in this.eventsArray){
                console.log("Hello");
            }
            return card;
        }

        echoTest(){
            this.formSingleCardsArray();
        }

     
    }

    let main_slideshow = new Slideshow();
    main_slideshow.echoTest();

} )(jQuery);