function Ajax(URL, funcion, datos) {
    Ajax.prototype.READY_STATE_UNINITIALIZED = 0;
    Ajax.prototype.READY_STATE_LOADING = 1;
    Ajax.prototype.READY_STATE_LOADED = 2;
    Ajax.prototype.READY_STATE_INTERACTIVE = 3;
    Ajax.prototype.READY_STATE_COMPLETE = 4;

    this.metodoEnvio = 'GET';
    this.URL = URL;
    this.funcionAsignada = funcion;
    datos ? this.datos = datos : this.datos = null;
    this.peticionHttp = null;

    this.peticionHttp = null;
    if (window.XMLHttpRequest) {
        this.peticionHttp = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        this.peticionHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    Ajax.prototype.onReadyState = function () {
        var ajax = this;
        if (ajax.peticionHttp.readyState == ajax.READY_STATE_COMPLETE &&
                ajax.peticionHttp.status == 200) {
            ajax.funcionAsignada.call(ajax);
        }
    }

    Ajax.prototype.setURL = function (URL) {
        this.URL = URL;
    }

    Ajax.prototype.getHttpRequest = function () {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    Ajax.prototype.enviarPeticion = function () {
        var auxAjax = this;
        this.peticionHttp.onreadystatechange = function () {
            auxAjax.onReadyState.call(auxAjax);
        }
        
        this.peticionHttp.open(this.metodoEnvio, this.URL, true);
        if(this.metodoEnvio == 'POST') {
            this.peticionHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        }
        this.peticionHttp.send(this.datos);
    }

    Ajax.prototype.setMetodoEnvio = function (metodoEnvio) {
        this.metodoEnvio = metodoEnvio;
    }
}