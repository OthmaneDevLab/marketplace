$(document).ready(function () {

    var notificationsWrapper   = $('.dropdown-notifications');
    if (!notificationsWrapper.length) return;

    var notificationsCountElem = notificationsWrapper.find('.notif-count');
    var notificationsCount     = parseInt(notificationsCountElem.data('count')) || 0;
    var notifications          = notificationsWrapper.find('.scrollable-container');

    var channel = pusher.subscribe('new-notification');

    channel.bind('new.notification', function (data) {

        var existingNotifications = notifications.html();

        var newNotificationHtml =
            '<a href="' + data.path + '" class="dropdown-item">' +
                '<strong>New order:</strong> ' + data.user_id + '<br>' +
                '<strong>New order:</strong> ' + data.product_name + '<br>' +
                '<small class="text-muted">' +
                    data.date + ' ' + data.time +
                '</small>' +
            '</a>';

        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount++;
        notificationsCountElem
            .attr('data-count', notificationsCount)
            .text(notificationsCount);
    });

});
