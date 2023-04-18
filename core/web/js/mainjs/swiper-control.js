const swiperEl = document.querySelector('.swiper')

const params = {
  injectStyles: [`
  .swiper-pagination-bullet {
    width: 23px;
    height: 23px;
    opacity: 0.2;
    border-radius: 5px;
    background: #000E1A;
  }

  .swiper-pagination-bullet-active {
    opacity: 1;
    background: linear-gradient(180deg, #DF2C56 0%, #C81F47 100%);
  }
  `],
  pagination: {
    clickable: true,
  },
}

Object.assign(swiperEl, params)