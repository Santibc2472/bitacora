
/**
window.onload = function(){
    
    
)
**/

var upgradeData;
var schedule_data = schedule_data;
var setting_data = setting_data;
if(schedule_data != null){
    
    upgradeData = schedule_data;
    
}else if(setting_data != null){
    
    upgradeData = setting_data;
    
}

if (document.getElementById("upgradeButton") != null) {
    
    var upgradeButton = document.getElementById("upgradeButton");
    upgradeButton.onclick = function(){
        
        console.log(upgradeDetail);
        console.log(upgradeData);
        console.log(upgrade_dictionary);
        
        //var url = "https://test.cartmaker.net/api/";
        var upgrade = new Upgrade(upgradeDetail, upgradeData, upgrade_dictionary, false);
        
    }
    
}





function Upgrade(upgradeDetail, upgradeData, upgrade_dictionary, webApp) {
    
    console.log(upgradeData);
    console.log(upgradeDetail);
    var object = this;
    var upgrade_blockPanel = document.getElementById("upgrade_blockPanel");
    var upgrade_media_modal_close = document.getElementById("upgrade_media_modal_close");
    var upgradePanel = document.getElementById("upgradePanel");
    
    this._webApp = webApp;
    
    this._prefix = upgradeData.prefix;
    console.log(this._prefix);
    this._i18n = new I18n(upgradeDetail.locale);
    this._i18n.setDictionary(upgrade_dictionary);
    
    this._upgradeData = upgradeData;
    this._upgradeUrl = upgradeDetail.extension_url;
    this._upgradeDetail = upgradeDetail;
    this._upgrade_blockPanel = upgrade_blockPanel;
    this._upgradePanel = upgradePanel;
    
    var local = upgradeDetail.locale
    /**
    this.setUpgradeData(upgradeData);
    this.setUpgradeUrl(upgradeDetail.extension_url);
    this.setUpgradeDetail(upgradeDetail);
    this.setUpgradeBlockPanel(upgrade_blockPanel);
    this.setUpgradePanel(upgradePanel);
    **/
    
    var upgradeButton = document.getElementById("upgradeButton");
    var upgrade_leftButtonPanel = document.getElementById("upgrade_leftButtonPanel");
    var upgrade_rightButtonPanel = document.getElementById("upgrade_rightButtonPanel");
    
    var loadingPanel = document.getElementById("loadingPanel");
    loadingPanel.setAttribute("class", "loading_modal_backdrop");
    
    
    var post = {site: upgradeDetail.site, local: local};
    var xmlHttp = new Booking_App_XMLHttp(this._upgradeUrl + "plans/", post, this.webApp, function(response){
            
        loadingPanel.setAttribute("class", "hidden_panel");
        
        var upgrade_nonce = response.nonce;
        var plansData = response.plans;
        
        console.log(upgrade_nonce);
        console.log(plansData);
        
        var upgradeContentPanel = document.getElementById("upgrade_content_panel");
        console.log(upgradeContentPanel);
        upgradeContentPanel.setAttribute("class", "media_left_zero");
        document.getElementById("upgrade_menu_panel").setAttribute("class", "media_frame_menu hidden_panel");
        document.getElementById("upgrade_media_title").setAttribute("class", "media_left_zero");
        document.getElementById("upgrade_media_router").setAttribute("class", "media_left_zero");
        document.getElementById("upgrade_frame_toolbar").setAttribute("class", "media_frame_toolbar media_left_zero");
        
        object.createPlansMainPanel(upgradeContentPanel, plansData, upgrade_nonce);
        object.upgradeEditPanelShow(true);
        
    });
    
    //upgrade_blockPanel.removeEventListener("click", event);
    upgrade_blockPanel.onclick = function(){
        
        upgrade_leftButtonPanel.textContent = null;
        upgrade_rightButtonPanel.textContent = null;
        object.upgradeEditPanelShow(false);
        
    }
    
    //upgrade_media_modal_close.removeEventListener("click", event);
    upgrade_media_modal_close.onclick = function(){
        
        upgrade_leftButtonPanel.textContent = null;
        upgrade_rightButtonPanel.textContent = null;
        object.upgradeEditPanelShow(false);
        
    }
    
    this.setUrl = function(url){
        
        this._url = url;
        
    }
    
    this.getUrl = function(){
        
        return this._url;
        
    }
    
    this.setUpgradeUrl = function(url){
        
        this._upgradeUrl = url;
        
    }
    
    this.getUpgradeUrl = function(){
        
        return this._upgradeUrl;
        
    }
    
    this.setUpgradeData = function(upgradeData){
        
        this._upgradeData = upgradeData;
        
    }
    
    this.getUpgradeData = function(){
        
        return this._upgradeData;
        
    }
    
    this.setPost = function(post){
        
        this._post = post;
        
    }
    
    this.getPost = function(){
        
        return this._post;
        
    }
    
    this.setUpgradeDetail = function(data){
        
        this._upgradeDetail = data;
        
    }
    
    this.getUpgradeDetail = function(){
        
        return this._upgradeDetail;
        
    }
    
    this.setUpgradePanel = function(panel){
        
        this._upgradePanel = panel;
        
    }
    
    this.getUpgradePanel = function(){
        
        return upgradePanel;
        
    }
    
    this.setUpgradeBlockPanel = function(panel){
        
        console.log(panel);
        this._upgrade_blockPanel = panel;
        
    }
    
    this.getUpgradeBlockPanel = function(){
        
        return this._upgrade_blockPanel;
        
    }
    
    this.setCallback = function(callback){
        
        this._callback = callback;
        
    }
    
    this.getCallback = function(){
        
        return this._callback;
        
    }
    
    this.upgradeEditPanelShow = function(showBool){
        
        var body = document.getElementsByTagName("body")[0];
        if(showBool == true){
            
            body.classList.add("modal-open");
            this.getUpgradePanel().setAttribute("class", "edit_modal");
            this.getUpgradeBlockPanel().setAttribute("class", "edit_modal_backdrop");
            
        }else{
            
            body.classList.remove("modal-open");
            this.getUpgradePanel().setAttribute("class", "hidden_panel");
            this.getUpgradeBlockPanel().setAttribute("class", "hidden_panel");
            
        }
        
    }
    
    this.i18n = function(str, args){
        
        var value = this._i18n.get(str, args);
        return value;
        
    }
    
    this.createPlansMainPanel = function(upgradeContentPanel, plansData, upgrade_nonce){
        
        var object = this;
        upgradeContentPanel.textContent = null;
        
        var titlePanel = document.createElement("div");
        titlePanel.classList.add("titlePanel");
        //titlePanel.textContent = object.i18n("Please choose a plan.");
        titlePanel.textContent = object.i18n("By upgrading to the \"Standard Plan\" you can use all the functions of the Booking Package.");
        upgradeContentPanel.appendChild(titlePanel);
        
        var mainPanel = document.createElement("div");
        mainPanel.classList.add("mainPanel");
        upgradeContentPanel.appendChild(mainPanel);
        
        var plansList = {name: ["Plans"], initial: ["Initial cost"], price: ["Per month"]};
        for(var i = 0; i < plansData.length; i++){
            
            plansList.name.push(plansData[i].name);
            plansList.initial.push(plansData[i].initial_cost);
            plansList.price.push(plansData[i].price);
            
            
        }
        
        var table = document.createElement("table");
        mainPanel.appendChild(table);
        for(var key in plansList) {
            
            var tr = document.createElement("tr");
            table.appendChild(tr);
            var plans = plansList[key];
            console.log(plans);
            for(var i = 0; i < plans.length; i++) {
                
                var td = document.createElement("td");
                td.textContent = plans[i];
                tr.appendChild(td);
                
            }
            
        }
        
        return null;
        
        for(var i = 0; i < plansData.length; i++){
            
            var planNameLabel = document.createElement("label");
            planNameLabel.classList.add("planNameLabel");
            planNameLabel.textContent = plansData[i].name;
            
            var initialFeeLabel = document.createElement("label");
            initialFeeLabel.classList.add("priceLabel");
            initialFeeLabel.textContent = plansData[i].initial_cost;
            
            var priceLabel = document.createElement("label");
            priceLabel.classList.add("priceLabel");
            priceLabel.textContent = plansData[i].price;
            
            var planPanel = document.createElement("div");
            planPanel.setAttribute("data-key", plansData[i].id);
            planPanel.classList.add("planPanel");
            planPanel.appendChild(planNameLabel);
            planPanel.appendChild(initialFeeLabel);
            planPanel.appendChild(priceLabel);
            
            mainPanel.appendChild(planPanel);
            /**
            for(var key in plansData[i].functionsList){
                
                var bool = plansData[i].functionsList[key];
                console.log(key + " = " + bool);
                var functionLabel = document.createElement("label");
                functionLabel.classList.add("functionLabel");
                if(parseInt(bool) == 0){
                    
                    functionLabel.classList.add("false");
                    
                }else{
                    
                    functionLabel.classList.add("true");
                    
                }
                
                functionLabel.textContent = key;
                planPanel.appendChild(functionLabel);
                
                //object.getUpgradeUrl();
                
            }
            **/
            if(plansData[i].id != "free_plan"){
                
                var form = document.createElement("form");
                form.setAttribute("class", "functionLabel upgradePanel");
                planPanel.appendChild(form);
                form.method = "post";
                form.action = "https://saasproject.net/upgrade/";
                
                //this._upgradeDetail
                var postList = {
                    id: plansData[i].id,
                    getUpgradeUrl: object.getUpgradeUrl(), 
                    local: this._upgradeDetail.local, 
                    timeZone: this._upgradeDetail.timeZone,
                    extension_url: this._upgradeDetail.extension_url,
                    site: this._upgradeDetail.site,
                    pluginUrl: this._upgradeDetail.pluginUrl,
                };
                
                for(var key in postList){
                    
                    var hidden = document.createElement("input");
                    hidden.type = "hidden";
                    hidden.name = key;
                    hidden.value = postList[key];
                    form.appendChild(hidden);
                    
                }
                
                var submit = document.createElement("input");
                submit.setAttribute("class", "media-button button-primary button-large media-button-insert");
                submit.type = "submit";
                submit.value = object._i18n.get("Upgrade");
                form.appendChild(submit);
                
            }
            
            var bottomLabel = document.createElement("label");
            bottomLabel.classList.add("bottomLabel");
            planPanel.appendChild(bottomLabel);
            
            /**
            if(parseInt(this._upgradeDetail.secure) == 0){
                
                window.alert(this._i18n.get("To subscribe to the paid version of Booking Package you must use HTTPS."));
                return null;
                
            }
            **/
            
            /**
            planPanel.onclick = function(event){
                
                var planId = this.getAttribute("data-key");
                if(planId != "free_plan"){
                    
                    console.log("planId = " + planId);
                    object.careteUpgradeFrom(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId);
                    
                }
                
            }
            **/
            
        }
        
    }
    
    this.careteUpgradeFrom = function(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId){
        
        var object = this;
        var formList = [];
        formList.push({id: "firstName", name: object.i18n("First Name"), type: "TEXT", active: "true", required: "true", isEmail: "false", value: ""});
        formList.push({id: "lastName", name: object.i18n("Last Name"), type: "TEXT", active: "true", required: "true", isEmail: "false", value: ""});
        formList.push({id: "email", name: object.i18n("Email address"), type: "TEXT", active: "true", required: "true", isEmail: "true", value: ""});
        var stripe_public_key = this.getUpgradeDetail().stripe_public_key;
        console.log("stripe_public_key = " + stripe_public_key);
        var plan = null;
        for(var i = 0; i < plansData.length; i++){
            
            if(plansData[i].id == planId){
                
                plan = plansData[i];
                break;
                
            }
            
        }
        
        if(plan != null){
            
            console.log(plan);
            
            var planNameLabel = document.createElement("div");
            planNameLabel.classList.add("planNameLabel");
            planNameLabel.textContent = plan.name;
            
            var initialFeeLabel = document.createElement("div");
            initialFeeLabel.classList.add("priceLabel");
            initialFeeLabel.textContent = plan.initial_cost;
            
            var priceLabel = document.createElement("div");
            priceLabel.classList.add("priceLabel");
            priceLabel.textContent = plan.price;
            
            var planPanel = document.createElement("div");
            planPanel.setAttribute("data-key", plansData[i].id);
            planPanel.classList.add("formPanel");
            planPanel.appendChild(planNameLabel);
            planPanel.appendChild(initialFeeLabel);
            planPanel.appendChild(priceLabel);
            
            for(var key in plan.functionsList){
                
                var bool = plan.functionsList[key];
                console.log(key + " = " + bool);
                var functionLabel = document.createElement("div");
                functionLabel.classList.add("functionLabel");
                functionLabel.classList.add("true");
                functionLabel.textContent = key;
                planPanel.appendChild(functionLabel);
                
            }
            
            var formPanel = document.createElement("div");
            formPanel.classList.add("formPanel");
            
            upgradeContentPanel.textContent = null;
            var mainPanel = document.createElement("div");
            mainPanel.id = "upgradeInputFormPanel";
            upgradeContentPanel.appendChild(mainPanel);
            mainPanel.appendChild(planPanel);
            mainPanel.appendChild(formPanel);
            
            var formPanelList = {};
            var inputData = {};
            var input = new Booking_Package_Input();
            for(var i = 0; i < formList.length; i++){
                
                if(formList[i].active != 'true'){
                    
                    continue;
                    
                }
                
                var value = input.createInput(i, formList[i], inputData);
                var rowPanel = this.createRowPanel(formList[i]['name'], value, formList[i].required);
                formPanelList[i] = rowPanel;
                formPanel.appendChild(rowPanel);
                
            }
            
            var setUpgradeDetail = object.getUpgradeDetail();
            console.log(setUpgradeDetail);
            
            var buttonPanel = document.createElement("div");
            buttonPanel.classList.add("buttonPanel");
            //buttonPanel.appendChild(continueButton);
            formPanel.appendChild(buttonPanel);
            
            
            /** Stripe v3 **/
            
            var stripe = Stripe(stripe_public_key);
            
            var elements = stripe.elements();
            var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };
            
            var titleLabel = document.createElement("label");
            titleLabel.setAttribute("for", "card-element");
            titleLabel.textContent = object.i18n("Credit card");
            
            var card_element = document.createElement("div");
            card_element.id = "card-element";
            
            var card_errors = document.createElement("div");
            card_errors.id = "card-errors";
            card_errors.setAttribute("role", "alert");
            
            var submit_payment = document.createElement("button");
            submit_payment.textContent = object.i18n("Submit Payment");
            submit_payment.setAttribute("class", "media-button button-primary button-large media-button-insert");
            
            var form_row = document.createElement("div");
            form_row.classList.add("form-row");
            form_row.appendChild(titleLabel);
            form_row.appendChild(card_element);
            form_row.appendChild(card_errors);
            form_row.appendChild(submit_payment);
            
            var payment_form = document.createElement("form");
            payment_form.id = "payment-form";
            //payment_form.action = "/charge";
            //payment_form.method = "post";
            payment_form.appendChild(form_row);
            
            
            
            buttonPanel.appendChild(payment_form);
            
            var card = elements.create('card', {style: style, hidePostalCode: true});
            card.mount('#card-element');
            
            
            
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                
                console.log("submit");
                event.preventDefault();
                
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the customer that there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server
                        //stripeTokenHandler(result.token);
                        console.log(result.token);
                        validateInputFileds(result.token.id, function(callback){
                            
                            if(callback == "fail"){
                                
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = object.i18n("You have to input missing text fields.");
                                
                            }
                            
                        });
                        
                    }
                
                });
            });
            
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            
            /** Apple pay AND Pay with Google **/
            
            var orLabel = document.createElement("div");
            orLabel.setAttribute("class", "orLabel hidden_panel");
            orLabel.textContent = "or";
            buttonPanel.appendChild(orLabel);
            
            var payTypeLabel = document.createElement("div");
            payTypeLabel.setAttribute("class", "payTypeLabel hidden_panel");
            buttonPanel.appendChild(payTypeLabel);
            
            var payment_request_button = document.createElement("div");
            payment_request_button.id = "payment-request-button";
            buttonPanel.appendChild(payment_request_button);
            
            var paymentRequest = stripe.paymentRequest({
                country: 'JP',
                currency: 'usd',
                total: {
                    label: 'Initial fee and Per month fee',
                    amount: 800,
                },
                displayItems: [
                        {label: "Initial fee", amount: 400},
                        {label: "Per month fee", amount: 400}
                    ]
            });
            
            var prButton = elements.create('paymentRequestButton', {
                paymentRequest: paymentRequest,
                style: {
                    paymentRequestButton: {
                        type: 'default', // default: 'default'
                        theme: 'light-outline', // default: 'dark'
                        height: '40px', // default: '40px', the width is always '100%'
                    },
                }
            });
            
            
            
            // Check the availability of the Payment Request API first.
            paymentRequest.canMakePayment().then(function(result) {
                if(result){
                    
                    console.log(result.applePay);
                    if(result.applePay === false){
                        
                        payTypeLabel.textContent = "Pay with Google";
                        
                    }else{
                        
                        payTypeLabel.textContent = "Apple pay";
                        
                    }
                    
                    orLabel.classList.remove("hidden_panel");
                    payTypeLabel.classList.remove("hidden_panel");
                    prButton.mount('#payment-request-button');
                    
                }else{
                    
                    document.getElementById('payment-request-button').style.display = 'none';
                    
                }
                
            });
            
            paymentRequest.on('token', function(ev) {
                // Send the token to your server to charge it!
                
                console.log(ev);
                console.log(JSON.stringify({token: ev.token.id}));
                
                validateInputFileds(ev.token.id, function(callback){
                    
                    if(callback == "success"){
                        
                        ev.complete('success');
                        var tokenLabel = document.createElement("div");
                        tokenLabel.textContent = ev.token.id;
                        buttonPanel.appendChild(tokenLabel);
                        
                    }else{
                        
                        ev.complete('fail');
                        console.log(ev);
                        
                    }
                    
                });
                
            });
            
            
            var link = document.createElement("a");
            link.setAttribute("target", "_blank");
            link.setAttribute("href", "https://saasproject.net/terms/");
            link.textContent = "the terms of Service";
            
            var termsPanel = document.createElement("span");
            //termsPanel.innerHTML = 'By taking out a subscription, you agree to <a href="https://saasproject.net/terms/" target="_blank">the terms of Service</a>.';
            termsPanel.innerHTML = object.i18n('By taking out a subscription, you agree to %s.', ['<a href="https://saasproject.net/terms/" target="_blank">' + object.i18n("the terms of Service") + '</a>']);
            
            var termsOfService = "By taking out a subscription, you agree to the terms of Service.";
            
            rowPanel = this.createRowPanel(null, termsPanel, "false");
            rowPanel.classList.add("termsOfService");
            formPanel.appendChild(rowPanel);
            
            var returnButton = document.createElement("button");
            returnButton.setAttribute("class", "media-button button-primary button-large media-button-insert");
            returnButton.textContent = object.i18n("Return");
            
            var upgrade_rightButtonPanel = document.getElementById("upgrade_rightButtonPanel");
            upgrade_rightButtonPanel.setAttribute("style", "float: right;");
            upgrade_rightButtonPanel.appendChild(returnButton);
            
            returnButton.onclick = function(){
                
                object.createPlansMainPanel(upgradeContentPanel, plansData, upgrade_nonce);
                upgrade_rightButtonPanel.textContent = null;
                
            }
            
            var validateInputFileds = function(token, callback){
                
                console.log("token = " + token);
                var post = {nonce: upgrade_nonce, token: token, id: planId, local: setUpgradeDetail.local, timeZone: setUpgradeDetail.timeZone, site: setUpgradeDetail.site};
                for(var key in formPanelList){
                    
                    var bool = input.inputCheck(key, formList[key], inputData[key], []);
                    console.log("bool = " + bool);
                    if(bool == false){
                        
                        post = false;
                        formPanelList[key].classList.add("errorPanel");
                        
                    }else{
                        
                        for(var valueKey in inputData[key]){
                            
                            if(formList[key].type == "TEXT"){
                                
                                post[formList[key].id] = inputData[key][valueKey].value;
                                
                            }
                            
                        }
                        
                        formPanelList[key].classList.remove("errorPanel");
                        
                    }
                    
                }
                
                console.log(post);
                if(post !== false){
                    
                    callback("success");
                    
                    var loadingPanel = document.getElementById("loadingPanel");
                    loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    
                    var url = object.getUpgradeUrl() + "entry/";
                    var xmlHttp = new Booking_App_XMLHttp(url, post, object._webApp, function(response){
                        
                        console.log(response);
                        object.checkLicense(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId, response, post.email);
                        
                    });
                    
                }else{
                    
                    callback("fail");
                    
                }
                
            }
            
        }
        
    }
    
    this.send = function(token){
        
        var object = this;
        var loadingPanel = document.getElementById("loadingPanel");
        loadingPanel.setAttribute("class", "loading_modal_backdrop");
        
        var callback = this.getCallback();
        var post = this.getPost();
        post.token = token;
        var url = this.getUpgradeUrl() + "entry/";
        var xmlHttp = new Booking_App_XMLHttp(url, post, object._webApp, function(response){
                
            console.log(response);
            callback(response);
            
        });
        
    }
    
    this.checkLicense = function(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId, entryResponse, email){
        
        var object = this;
        var loadingPanel = document.getElementById("loadingPanel");
        loadingPanel.setAttribute("class", "hidden_panel");
        loadingPanel.setAttribute("class", "loading_modal_backdrop");
        
        var object = this;
        if(entryResponse.status == "success"){
            
            var upgradeData = object.getUpgradeData();
            var post = {mode: "upgradePlan", type: "regist", nonce: upgradeData.nonce, action: upgradeData.action, customer_email_for_subscriptions: email, customer_id_for_subscriptions: entryResponse.customer_id, id_for_subscriptions: entryResponse.subscriptions_id};
            console.log(post);
            var xmlHttp = new Booking_App_XMLHttp(upgradeData.url, post, object._webApp, function(response){
                
                //loadingPanel.setAttribute("class", "hidden_panel");
                console.log(response);
                if(response.status == "success"){
                    
                    //var post = object.getPost();
                    var url = object.getUpgradeUrl() + "license/";
                    post["customer_id"] = entryResponse.customer_id;
                    post["subscriptions_id"] = entryResponse.subscriptions_id;
                    
                    var getLicense = function (){
                        
                        console.log(post);
                        var xmlHttp = new Booking_App_XMLHttp(url, post, object._webApp, function(response){
                            
                            if(response.status != 0 && response.status != "error"){
                                
                                console.log(response);
                                
                                var upgradeData = object.getUpgradeData();
                                var post = {
                                    mode: "upgradePlan", 
                                    type: "update", 
                                    nonce: upgradeData.nonce, 
                                    action: upgradeData.action, 
                                    invoice_id_for_subscriptions: response.invoice_id, 
                                    expiration_date_for_subscriptions: response.expiration_date};
                                console.log(post);
                                var xmlHttp = new Booking_App_XMLHttp(upgradeData.url, post, object._webApp, function(response){
                                    
                                    console.log(response);
                                    loadingPanel.setAttribute("class", "hidden_panel");
                                    object.paymentIsComplete(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId, entryResponse, email, entryResponse.customer_id, entryResponse.subscriptions_id);
                                    
                                });
                                
                            }else{
                                
                                console.log("retry");
                                var myVar = setInterval(
                                    function(){
                                        
                                        
                                        getLicense();
                                        clearInterval(myVar);
                                        
                                    }, 3000);
                                
                            }
                            
                        });
                        
                    };
                    
                    getLicense();
                    
                }
                
            });
            
            
            
        }else{
            
            /** ERROR **/
            loadingPanel.setAttribute("class", "hidden_panel");
            window.alert("We failed your request.");
            
        }
        
    }
    
    this.paymentIsComplete = function(upgradeContentPanel, planPanel, plansData, upgrade_nonce, planId, entryResponse, email, customer_id, subscriptions_id){
        
        console.log("email = " + email + " customer_id = " + customer_id + " subscriptions_id = " + subscriptions_id);
        
        var object = this;
        var title = object.i18n("Thank you for signing up for the subscription.");
        var message = object.i18n("Please reload this browser.");
        
        upgradeContentPanel.textContent = null;
        var titlePanel = document.createElement("div");
        titlePanel.setAttribute("style", "margin-top: 20px;");
        titlePanel.classList.add("titlePanel");
        titlePanel.textContent = title;
        upgradeContentPanel.appendChild(titlePanel);
        
        var reloadButton = document.createElement("button");
        reloadButton.setAttribute("class", "media-button button-primary button-large media-button-insert");
        reloadButton.textContent = message;
        
        var buttonPanel = document.createElement("div");
        buttonPanel.setAttribute("style", "margin-top: 20px; text-align: center;");
        buttonPanel.appendChild(reloadButton);
        
        upgradeContentPanel.appendChild(buttonPanel);
        
        reloadButton.onclick = function(){
            
            window.location.reload();
            
        }
        
       
        
        
    }
    
    this.createRowPanel = function(name, value, required){
        
        console.log(typeof value);
        var namePanel = document.createElement("div");
        if(name != null){
            
            namePanel.setAttribute("class", "name");
            namePanel.textContent = name;
            if(required == 'true'){
                
                namePanel.setAttribute("class", "name required");
                
            }
            
        }
        
        
        var inputPanel = null;
        if(typeof value == 'string'){
            
            inputPanel = document.createElement("div");
            inputPanel.textContent = value;
            
        }else{
            
            inputPanel = value;
            
        }
        inputPanel.setAttribute("class", "value");
        
        var rowPanel = document.createElement("div");
        rowPanel.setAttribute("class", "row");
        rowPanel.appendChild(namePanel);
        rowPanel.appendChild(inputPanel);
        
        return rowPanel;
        
    }
    
}

