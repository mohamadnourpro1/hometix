import './bootstrap';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const initPopularSwiper = () => {
    const swiperElement = document.querySelector('.js-popular-swiper');

    if (!swiperElement) {
        return;
    }

    const nextButton = document.querySelector('.js-popular-next');
    const prevButton = document.querySelector('.js-popular-prev');
    const pagination = document.querySelector('.js-popular-pagination');

    new Swiper(swiperElement, {
        modules: [Navigation, Pagination],
        slidesPerView: 1.2,
        spaceBetween: 12,
        navigation: {
            nextEl: nextButton,
            prevEl: prevButton,
        },
        pagination: {
            el: pagination,
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2.2,
                spaceBetween: 16,
            },
            1024: {
                slidesPerView: 3.2,
                spaceBetween: 18,
            },
        },
    });
};

const initMediaSwiper = () => {
    const swiperElement = document.querySelector('.js-media-swiper');

    if (!swiperElement) {
        return;
    }

    new Swiper(swiperElement, {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 12,
        pagination: {
            el: '.js-media-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.js-media-next',
            prevEl: '.js-media-prev',
        },
    });
};

const initYoutubeInputRepeater = () => {
    const addButton = document.querySelector('[data-add-youtube]');
    const wrapper = document.querySelector('[data-youtube-wrapper]');

    if (!addButton || !wrapper) {
        return;
    }

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'flex gap-2';
        row.innerHTML =
            '<input type="url" name="youtube_urls[]" placeholder="https://www.youtube.com/watch?v=..." class="input-control" />';

        wrapper.appendChild(row);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initPopularSwiper();
    initMediaSwiper();
    initYoutubeInputRepeater();
});
