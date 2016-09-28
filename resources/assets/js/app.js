$(function () {
    $(document).on({
        ready: function () {
            $('[data-toggle="tooltip"]').tooltip();

            $(".confirm-action").on('click', function () {
                if (!confirm("Confirm action?")) {
                    return false;
                }
            });

            $(".select2").select2({
                theme: "bootstrap"
            });

            $(".date-time-picker").datetimepicker({
                minDate: moment()
            });

            $("#set-welcome-message").on("change", function () {
                $(this).closest("form").submit();
            });

            var $newProjectSelectPageButton = $("#new-project-select-page"),
                $newProjectClearPageButton = $("#new-project-clear-page");

            $newProjectClearPageButton.on("click", function () {
                $("input[name='page_title']").val("");
                $("input[name='page_id']").val("");
                $("input[name='page_token']").val("");

                $("#selected-page-name").html("- none -");

                $newProjectSelectPageButton.show();
                $newProjectClearPageButton.hide();
            });

            $newProjectSelectPageButton.on("click", function () {
                var $modalContainer = $("#select-page-modal");

                function listPages(uid)
                {
                    $(".modal-body > .list-group", $modalContainer).html("");

                    FB.api("/" + uid + "/accounts", function (response) {
                        if (response.data.length > 0) {
                            $.each(response.data, function (i, page) {
                                $(".modal-body > .list-group", $modalContainer).append(
                                    "<button data-page-id=\"" + page.id + "\" data-page-token=\"" + page.access_token + "\" data-page-name=\"" + page.name + "\" type=\"button\" class=\"list-group-item\">" + page.name + "</button>"
                                );
                            });

                            attachEventListeners();

                            $modalContainer.modal();
                        } else {
                            alert("No pages were found!");
                        }
                    });
                }

                function attachEventListeners()
                {
                    $(".modal-body > .list-group > button").each(function (i, button) {
                        $(button).on("click", function (e) {
                            $("input[name='page_title']").val($(this).data("page-name"));
                            $("input[name='page_id']").val($(this).data("page-id"));
                            $("input[name='page_token']").val($(this).data("page-token"));

                            $("#selected-page-name").html($(this).data("page-name"));

                            $modalContainer.modal("hide");

                            $newProjectSelectPageButton.hide();
                            $newProjectClearPageButton.show();
                        });
                    });
                }

                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        listPages(response.authResponse.userID);
                    } else {
                        FB.login(function(response) {
                            if (response.authResponse) {
                                FB.api('/me', function(response) {
                                    listPages(response.id);
                                });
                            } else {
                                alert("Please authorize and select page!");
                            }
                        }, { scope: "manage_pages,pages_messaging" });
                    }
                }, true);
            });
        }
    });
});