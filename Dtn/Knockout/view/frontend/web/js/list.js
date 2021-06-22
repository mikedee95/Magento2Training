define([ // define function with dependencies.
        'jquery',
        'uiComponent',
        'mage/validation',
        'ko',
        'Magento_Ui/js/modal/modal',
        'mage/url',
    ],
    function ($, Component, validation, ko, modal, urlBuilder) {
        'use strict';
        let title = "";
        return Component.extend({

            defaults: {
                template: 'Dtn_Knockout/list'
            },

            totalEmployee: ko.observableArray([]), //detect change of employee list, bind a list of elements

            initialize: function (config) {
                // const self = this;
                this._super();
                if (config.employeeList.length > 0) {
                    this.totalEmployee(config.employeeList);
                    return this;
                }
            },

            //return employee list
            titles: function () {
                title = ko.observable("Employee List"); // define model properties which can notify the changes and update the model automatically
                return title;
            },

            currentEmployee: ko.observable(),

            // open modal edit
            editEmployee: function (employee) {
                this.currentEmployee(employee);
                console.log(employee);
                const popup = $("#employee-form-popup");
                let option = {
                    type: 'popup',
                    title: 'Edit employee',
                    responsive: true,
                    clickableOverlay: true,
                    'buttons': [{
                        text: 'Cancel',
                        class: 'action',
                    }],
                    closed: function () {
                    }
                };
                modal(option, $(popup));
                $(popup).modal("openModal");
            },

            //open modal add
            addEmployee: function () {
                const popup = $("#employee-form-popup");
                this.currentEmployee();
                let option = {
                    type: 'popup',
                    title: 'Add new employee',
                    responsive: true,
                    clickableOverlay: true,
                    'buttons': [{
                        text: 'Cancel',
                        class: 'action',
                    }],
                    closed: function () {
                    }
                };
                modal(option, $(popup));
                $(popup).modal("openModal");
            },
            //Save employee data into db
            save: function (data) {
                const url = urlBuilder.build("knockout/employee/create"); //create URL
                const employee = {},
                    self = this,
                    // get all data
                    formDataArray = $(data).serializeArray();
                formDataArray.forEach(function (entry) {
                    employee[entry.name] = entry.value;
                });
                // console.log(formDataArray);
                if ($(data).validation() && $(data).validation('isValid')) {
                    $.ajax({
                        url: url,
                        data: JSON.stringify(employee), // return JSON string of employee
                        type: "POST",
                        dataType: 'json',
                    })
                        .done(                   //callback upon successful completion of the ajax request
                            function (response) {
                                if (response) {
                                    $.each(response, function (x, v) {
                                        const indx = self.findIndex(self.totalEmployee(), v.employee_id);
                                        if (indx === -1) {
                                            self.totalEmployee.unshift(v);
                                        } else {
                                            const oldItem = self.totalEmployee()[indx];
                                            self.totalEmployee.replace(oldItem, v);
                                        }
                                    });
                                }
                            }
                        )
                    $('.action-close').click(); // trigger the click event
                }
            },

            //Exist check
            findIndex: function (arr, id) {
                let i = -1;
                arr.forEach(function (item, index) {
                    if (item.employee_id == id) {
                        i = index;
                    }
                });
                return i;
            },
            // delete employee


            remove: function (item) {
                const url = urlBuilder.build("knockout/employee/delete"); // delete URL
                const confirm_delete = confirm('Are you sure you want to delete this employee?');
                const self = this;
                if (confirm_delete) { // When user click OK on the popup message
                    const data = item;
                    $.ajax({
                        url: url,
                        data: data,
                        type: "POST",
                        dataType: 'json',
                    })
                        .done(
                            function (response) {
                                if (response) {
                                    self.totalEmployee.remove(function (employee) {
                                        return employee.employee_id == response.employee_id;
                                    });
                                }
                            }
                        )
                }
            },

            // getFirstname: function () {
            //     return typeof (this.currentEmployee()) != "undefined" ? this.currentEmployee().firstname : "";
            // }
        });
    }
);
