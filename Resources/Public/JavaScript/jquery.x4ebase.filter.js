(function (window, $, undefined){
    if ($ === undefined) {
        alert ('jQuery is not loaded!');
        return;
    }

    var X4e = (window.X4e || {}),
        X4ebase = X4e.X4ebase || (X4e.X4ebase = {}),
        FilterHandler = X4e.X4ebase.FilterHandler || (X4e.X4ebase.FilterHandler = {}),
        Filter = X4e.X4ebase.Filter || (X4e.X4ebase.Filter = {})
    ;

    /**
     * The FilterHandler object handles multiple forms with their specific filters individually
     */
    $.extend(X4ebase.FilterHandler, {
        Selectors: {
            filterContainer: '[data-x4ebase-filter-element-type="filter"]',
            contentContainer: '[data-x4ebase-filter-element-type="content"]',
        },
        Attributes: {
            connectId: 'data-x4ebase-filter-connect-id'
        },
        instances: [],
        init: function () {
            var self = this;
            $(this.Selectors.filterContainer).each(function () {
                var connectId = parseInt($(this).attr(self.Attributes.connectId));
                if (!connectId) {
                    console && console.error('You have to define an attribute "data-x4ebase-filter-connect-id" for all your filters.');
                }
                var $contentContainer = self.Utility.getContentContainerByConnectId(connectId);

                if (!$contentContainer.length > 0) {
                    console && console.error('You have to define an attribute "data-x4ebase-filter-connect-id" for your content container to bind it with the filters.');
                }

                self.instances.push(
                    new X4e.X4ebase.Filter($(this), $contentContainer, connectId)
                );
            });
        },
        Utility: {
            getContentContainerByConnectId: function (connectId) {
                var self = X4e.X4ebase.FilterHandler;
                return $(self.Selectors.contentContainer).filter('[' + self.Attributes.connectId + '="' + connectId + '"]').first();
            },
            getFiltersByConnectId: function (connectId) {
                var self = X4e.X4ebase.FilterHandler;
                return $(self.Selectors.filterContainer).filter('[' + self.Attributes.connectId + '="' + connectId + '"]');
            }
        }
    });

    /**
     * Constructor of Filter Object
     *
     * @param $filterContainer : jQuery
     * @param $contentContainer : jQuery
     * @param connectId : int
     * @constructor
     */
    X4e.X4ebase.Filter = function ($filterContainer, $contentContainer, connectId) {
        this.$filterContainer = $filterContainer;
        this.$contentContainer = $contentContainer;
        this.connectId = connectId;
        this.init();
    };

    /**
     * The filter object handles all filters applied on a specific form
     */
    $.extend(X4ebase.Filter.prototype, {
        /**
         * Literal object of element selectors
         */
        Selectors: {
            form: 'form',
            group: '[data-x4ebase-filter-group]',
            filterClearButton: '[data-x4ebase-filter-clear-btn]'
        },

        /**
         * Literal object of attribute names
         */
        Attributes: {
            ajaxUrl: 'data-x4ebase-filter-ajax-url'
        },

        /**
         * Literal object of class names
         */
        Classes: {
            isLoading: 'is-loading',
            hasFilter: 'has-filter'
        },

        /**
         * @var string ajaxUrl: Is set dynamically in registerAjaxEvents - method
         */
        ajaxUrl: null,

        /**
         * @var xhr ajaxRequest: Storage for the last ajaxRequest
         */
        lastAjaxRequest: null,

        /**
         * This method is invoked by the constructor
         */
        init: function () {
            this.$form = this.$filterContainer.find(this.Selectors.form);
            if (!this.$form.length > 0) {
                console && console.error("A x4ebase filter needs a form element to provide the data to the server.");
            }
            this.$allInputs = this.$form.find(':input').not('input[type="text"]');
            this.$filterClearButtons = this.$form.find(this.Selectors.filterClearButton);

            this.registerAjaxEvents();
        },

        /**
         * Registers an ajax event for the filter form
         */
        registerAjaxEvents: function () {
            this.ajaxUrl = this.$form.attr(this.Attributes.ajaxUrl);
            if (this.ajaxUrl !== undefined && this.ajaxUrl !== false) {
                this.$form.on('submit', $.proxy(this, 'onFormSubmit'));
                this.$allInputs.on('change', $.proxy(this, 'onAllInputChange'));
                this.$filterClearButtons.on('click', $.proxy(this, 'onClickFilterClearButton'));
            }
        },
        /**
         * Resets other bound filter forms present on the page
         */
        resetOtherFilters: function () {
            var self = this;
            var $otherFilters = X4e.X4ebase.FilterHandler.Utility.getFiltersByConnectId(this.connectId).not(this.$filterContainer);
            var $otherGroups = $otherFilters.find(this.Selectors.group);
            $otherFilters.find('form').trigger('reset');
            $otherFilters.find(':radio, :checkbox').removeAttr('checked');
            $otherGroups.each(function () {
                self.checkIfGroupHasActiveFilter($(this));
            });
        },
        /**
         * Checks weather a group has an active filter and sets or removes a class to allow handling
         *
         * @param $group
         */
        checkIfGroupHasActiveFilter: function ($group) {
            var hasActiveFilter = false;

            $group.find(this.$allInputs).each(function () {
                var $input = $(this);
                var elementType = this.nodeName.toLowerCase();

                switch (elementType) {
                    case 'input':
                        var type = $input.attr('type');
                        switch (type) {
                            case 'checkbox':
                            case 'radio':
                                if ($input.is(':checked')) {
                                    hasActiveFilter = true;
                                    return true;
                                }
                            break;
                            default:
                                if ($input.val() !== '') {
                                    hasActiveFilter = true;
                                    return true;
                                }
                            break;
                        }
                    break;
                    case 'select':
                        if ($input.is(':selected')) {
                            hasActiveFilter = true;
                            return true;
                        }
                    break;
                    case 'textarea':
                        if ($input.val() !== '') {
                            hasActiveFilter = true;
                            return true;
                        }
                    break;
                    default:
                        console && console.log('Unsupported form type.');
                    break;
                }
            });
            if (hasActiveFilter) {
                $group.addClass(this.Classes.hasFilter);
            } else {
                $group.removeClass(this.Classes.hasFilter);
            }
        },
        /**
         * Clears all filters of a given filter-group
         *
         * @param $group
         */
        clearFiltersOfGroup: function ($group) {
            $group.find(this.$allInputs)
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected')
            /**
             * Unfortunately the change event is not triggered automatically.
             * We have to trigger it manually and on the first element only, to prevent multiple ajax requests.
             */
                .first().trigger('change')
            ;
        },
        /**
         * Is called by clicking a filter-clear-button
         * Clears all filters of its group.
         *
         * @param ev: Event
         */
        onClickFilterClearButton: function (ev) {
            var $filterClearButton = $(ev.currentTarget);
            var $group = $filterClearButton.parents(this.Selectors.group).first();
            this.clearFiltersOfGroup($group);
        },
        /**
         * Is called after changing any filter form element (except for input[type="text"])
         *
         * @param ev: Event
         */
        onAllInputChange: function (ev) {
            var $input = $(ev.currentTarget);
            var $group = $input.parents(this.Selectors.group).first();
            this.checkIfGroupHasActiveFilter($group);
            this.onFormSubmit(ev)
        },
        /**
         * Is called by a submit event listener on the filter form element
         * Performs an ajax request to the defined url in the form attribute 'data-ajax-url'.
         * Maps the xhr result to the bound '[data-x4ebase-element-type="content"]' - element with the same connectId
         *
         * Info: The request dataType is currently set to 'html' by design, to keep the process simple.
         *
         * @param ev: Event
         */
        onFormSubmit: function (ev) {
            ev.preventDefault();

            //Cancel pending ajax request, if any. With readystate != 4 we exclude requests with "done" - state
            if(this.lastAjaxRequest && this.lastAjaxRequest.readystate != 4){
                this.lastAjaxRequest.abort();
            }

            this.resetOtherFilters();
            this.$contentContainer.addClass(this.Classes.isLoading);

            /**
             * Use this callback in another context, to trigger peripheral actions before the form is submitted
             * Usage: $(document).on('x4e:x4ebase-filter-before-form-submit', function())
             */
            $(document).triggerHandler('x4e:x4ebase-filter-before-form-submit');

            //Perform new ajax request
            this.lastAjaxRequest = $.ajax({
                url: this.ajaxUrl,
                type: this.$form.attr('method') ? this.$form.attr('method') : 'post',
                dataType: 'html',
                cache: false,
                data: this.$form.serialize(),
                error: $.proxy(this, 'onFormSubmitError'),
                success: $.proxy(this, 'onFormSubmitSuccess')
            }).always($.proxy(this, 'onFormSubmitAlways'));
        },
        /**
         * This method is called on a request error, or when a request has been canceled/aborted
         *
         * @param jqXHR
         * @param status: string status
         * @param errorMsg: string error message
         */
        onFormSubmitError: function (jqXHR, textStatus, errorThrown) {
            //console && console.error(errorMsg);
        },
        /**
         * This method is called after a successful request
         *
         * @param data
         * @param textStatus: string status
         * @param jqXHR: object jqXHR
         */
        onFormSubmitSuccess: function (data, textStatus, jqXHR) {
            this.$contentContainer.html(data);
            //This is necessary to provide binding after DOM update
            //this.$contentContainer = X4e.X4ebase.FilterHandler.Utility.getContentContainerByConnectId(this.connectId);
        },
        /**
         * This method is fired AFTER the error/timeout/success - callback
         *
         * @param data
         * @param textStatus: string status
         * @param jqXHR: object jqXHR
         */
        onFormSubmitAlways: function (data, textStatus, jqXHR) {
            this.$contentContainer.removeClass(this.Classes.isLoading);
            /**
             * Use this callback in another context, to trigger peripheral actions before the form is submitted
             * Usage: $(document).on('x4e:x4ebase-filter-before-form-submit', function())
             */
            $(document).triggerHandler('x4e:x4ebase-filter-after-form-submit');
        }
    });

    //Assign the X4e - literal to the window - object to make it available in the global namespace
    window.X4e = X4e;

})(window, jQuery);