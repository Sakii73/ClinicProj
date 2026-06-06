$(document).ready(function () {
    console.log("Main JS loaded.");

    // ── Helpers ──────────────────────────────────────────
    function showError(input, message) {
        input.addClass("input-error");
        if (input.next(".error-msg").length === 0) {
            input.after(`<span class="error-msg">${message}</span>`);
        }
    }

    function clearErrors(form) {
        form.find(".input-error").removeClass("input-error");
        form.find(".error-msg").remove();
    }

    // ── Walk-in Form (consult.php) ────────────────────────
    $("form[action='walk_in_ticket.php']").on("submit", function (e) {
        const form = $(this);
        clearErrors(form);
        let valid = true;

        const name = form.find("input[name='fullname']");
        const phone = form.find("input[name='phone']");
        const reason = form.find("select[name='reason']");

        if (name.val().trim() === "") {
            showError(name, "Full name is required.");
            valid = false;
        }

        if (!/^[0-9]{10,11}$/.test(phone.val().trim())) {
            showError(phone, "Enter a valid 10-11 digit phone number.");
            valid = false;
        }

        if (reason.val() === "" || reason.val() === null) {
            showError(reason, "Please select a reason for visit.");
            valid = false;
        }

        if (!valid) e.preventDefault();
    });

    // ── Book Appointment Form (book.php) ──────────────────
    $("form[action='schedule_ticket.php']").on("submit", function (e) {
        const form = $(this);
        clearErrors(form);
        let valid = true;

        const name = form.find("input[name='fullname']");
        const phone = form.find("input[name='phone']");
        const date = form.find("input[name='date']");
        const reason = form.find("select[name='reason']");

        if (name.val().trim() === "") {
            showError(name, "Full name is required.");
            valid = false;
        }

        if (!/^[0-9]{10,11}$/.test(phone.val().trim())) {
            showError(phone, "Enter a valid 10-11 digit phone number.");
            valid = false;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const selected = new Date(date.val());

        if (date.val() === "") {
            showError(date, "Please select a date.");
            valid = false;
        } else if (selected < today) {
            showError(date, "Date cannot be in the past.");
            valid = false;
        }

        if (reason.val() === "" || reason.val() === null) {
            showError(reason, "Please select a reason for visit.");
            valid = false;
        }

        if (!valid) e.preventDefault();
    });

    // ── Page Load Animations ──────────────────────────────
    $(".center-card, .service-card, .container").each(function (i) {
        $(this).css({ opacity: 0, transform: "translateY(30px)" });
        $(this).delay(i * 150).animate({ opacity: 1 }, {
            duration: 600,
            step: function (now) {
                const translate = 30 * (1 - now);
                $(this).css("transform", `translateY(${translate}px)`);
            }
        });
    });

    // ── Form Feedback Animations ──────────────────────────
    $("form").on("submit", function () {
        const btn = $(this).find("button[type='submit']");
        if ($(".input-error").length === 0) {
            btn.text("Submitting...").prop("disabled", true);
            btn.css("opacity", "0.7");
        }
    });

    $(".form-control").on("focus", function () {
        $(this).closest(".form-group").find("label").css({
            color: "var(--primary-blue)",
            transition: "color 0.3s ease"
        });
    }).on("blur", function () {
        $(this).closest(".form-group").find("label").css("color", "var(--text-main)");
    });

    // ── Input shake on error ──────────────────────────────
    $.fn.shake = function () {
        return this.each(function () {
            const el = $(this);
            let left = 0;
            const interval = setInterval(function () {
                el.css("margin-left", (left = -left || 8) + "px");
            }, 60);
            setTimeout(function () {
                clearInterval(interval);
                el.css("margin-left", "0px");
            }, 360);
        });
    };

    $("form").on("submit", function () {
        $(this).find(".input-error").shake();
    });
    // ── Show/Hide Elements ────────────────────────────────
    // Hide/show navbar on scroll
    let lastScroll = 0;
    $(window).on("scroll", function () {
        const current = $(this).scrollTop();
        if (current > lastScroll && current > 80) {
            $(".navbar").slideUp(300);
        } else {
            $(".navbar").slideDown(300);
        }
        lastScroll = current;
    });

    // Toggle hamburger menu (for future use)
    $(".nav-links a[href='#']").on("click", function (e) {
        e.preventDefault();
        const menu = $(".nav-links");
        menu.find("a:not(:last-child)").slideToggle(300);
    });

    // ── Real-time Form Feedback ───────────────────────────
    // Live name validation
    $("input[name='fullname']").on("input", function () {
        const val = $(this).val().trim();
        $(this).removeClass("input-error");
        $(this).next(".error-msg").remove();
        if (val.length > 0 && val.length < 3) {
            showError($(this), "Name must be at least 3 characters.");
        } else if (val.length >= 3) {
            $(this).css("border-color", "#22c55e");
        }
    });

    // Live phone validation
    $("input[name='phone']").on("input", function () {
        const val = $(this).val().trim();
        $(this).removeClass("input-error");
        $(this).next(".error-msg").remove();
        if (val.length > 0 && !/^[0-9]{10,11}$/.test(val)) {
            showError($(this), "Enter a valid 10-11 digit phone number.");
        } else if (/^[0-9]{10,11}$/.test(val)) {
            $(this).css("border-color", "#22c55e");
        }
    });

    // Live date validation
    $("input[name='date']").on("change", function () {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const selected = new Date($(this).val());
        $(this).removeClass("input-error");
        $(this).next(".error-msg").remove();
        if (selected < today) {
            showError($(this), "Date cannot be in the past.");
        } else {
            $(this).css("border-color", "#22c55e");
        }
    });

    // Live reason validation
    $("select[name='reason']").on("change", function () {
        $(this).removeClass("input-error");
        $(this).next(".error-msg").remove();
        if ($(this).val() !== "" && $(this).val() !== null) {
            $(this).css("border-color", "#22c55e");
        }
    });

    // ── Dynamic Queue Number ──────────────────────────────
    // Simulates a live queue number on walk_in_ticket.php
    if ($(".queue-number").length > 0) {
        let queue = parseInt($(".queue-number").text().replace("TKT - ", "")) || 1;

        // Animate queue number counting up on load
        $({ counter: 0 }).animate({ counter: queue }, {
            duration: 1000,
            step: function () {
                const num = String(Math.ceil(this.counter)).padStart(3, "0");
                $(".queue-number").text("TKT - " + num);
            }
        });

        // Simulate status updates
        const statuses = ["Waiting", "Almost Your Turn", "Please Proceed"];
        let statusIndex = 0;
        const statusEl = $(".ticket-box p");

        setInterval(function () {
            statusIndex = (statusIndex + 1) % statuses.length;
            statusEl.fadeOut(400, function () {
                $(this).text("Status : " + statuses[statusIndex]).fadeIn(400);
            });
        }, 5000);
    }
});