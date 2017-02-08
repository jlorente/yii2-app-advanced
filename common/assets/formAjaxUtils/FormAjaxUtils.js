/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

(function (window, document) {
    window.FormAjaxUtils = function () {
        this.formControlId = ".form-group";
        this.errorBlock = ".help-block-error";
        this.errorClass = "has-error";
    }
    /**
     * Create a FormData object from Html Form
     * @param {string} form  the form selector
     * @returns {FormData}
     */
    FormAjaxUtils.prototype.get = function (form) {
        var data;
        data = new FormData();
        $.each($(form).serializeArray(), function (i, field) {
            return data.append(field.name, field.value);
        });
        return data;
    };
    /**
     * Create a Json object from Html Form
     * @param {string} form  the form selector
     * @returns {Json}
     */
    FormAjaxUtils.prototype.getJson = function (form) {
        var data = {};
        $.each($(form).serializeArray(), function (i, field) {
            if (field.name.indexOf('[') != -1) {
                var keys = field.name.split('[');
                var form_key = keys[0];
                form_key = form_key.replace(']', '');
                if (!data.hasOwnProperty(form_key)) {
                    data[form_key] = {};
                }
                var property_key = keys[1];
                property_key = property_key.replace(']', '');
                data[form_key][property_key] = field.value;
            } else {
                data[field.name] = field.value;
            }

        });
        return data;
    };
    /**
     * Create http angular post request
     * @param {angular.$http} $http
     * @param {string} form
     * @param {string} url
     * @returns {request}
     */
    FormAjaxUtils.prototype.createRequest = function ($http, form, url) {
        form_data = this.getJson(form);
        console.log(form_data);
        var request = $http({
            method: "post",
            url: url,
            dataType: "json",
            data: form_data,
            headers: {'Content-Type': 'application/json;charset=utf-8'}
        });
        return request;
    }
    /**
     * Process Ajax response, show the errors into the form
     * @param {Json} data
     * @returns {Boolean}
     */
    FormAjaxUtils.prototype.processData = function (data) {
        var instance = this;
        var result = true;
        if (!data.result) {
            $(instance.formControlId).removeClass(instance.errorClass);
            angular.forEach(data.errors, function (value, key) {
                var id = "field-" + data.modelName + "-" + key;
                id = id.toLowerCase();
                var parent_item = $("." + id);
                console.log(parent_item);
                var item = parent_item.children(".error-container").children(instance.errorBlock);
                $(instance.formControlId).removeClass("has-success");
                parent_item.addClass(instance.errorClass);
                item.html(value);
                console.log(parent_item);
            });
            result = false;
        } else {
            $(".form-control").removeClass(instance.errorClass);
        }
        return result;
    }
    /**
     * Clear form 
     */
    FormAjaxUtils.prototype.clearForm = function () {
        var instance = this;
        $(instance.formControlId).removeClass(instance.errorClass);
        $(instance.formControlId).removeClass("has-success");
        $(instance.errorBlock).html("");
    }


})(window, document);

