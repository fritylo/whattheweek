function sniper() {
    const adv = document.getElementById('yandex_rtb_R-A-665787-1'),
        advRect = adv.getBoundingClientRect();

    if (advRect.width <= 0 || advRect.height <= 0) {
        // is ad blocker
        alert('Пожалуйста, отключите блокировщик рекламы 🥺 🙏\nПроект жив, только потому что вы видите рекламу, спасибо 🥰🤝 ');
    } else {
        // no ad blocker
    }
}

setTimeout(sniper, 3000);
