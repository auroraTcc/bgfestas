$(".question").each(function () {
    $(this).on("click", function () {
        let icon = $(this).find("i");
        if (icon.hasClass("fa-plus")) {
            icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            icon.removeClass("fa-minus").addClass("fa-plus");
        }

        let questionBody = $(this).find(".question-body");
        if (
            questionBody.css("max-height") !== "0px" &&
            questionBody.css("max-height") !== "none"
        ) {
            questionBody.css("max-height", "0px");
        } else {
            let scrollHeight = questionBody[0].scrollHeight;
            questionBody.css("max-height", scrollHeight + "px");
        }
    });
});
