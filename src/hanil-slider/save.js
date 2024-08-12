import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { images } = attributes;

  const blockProps = useBlockProps.save({ className: "home-slider" });

  return (
    <div {...blockProps}>
      <div className="swiper-wrapper home-slider-wrapper" data-slides="1">
        {(images || Array.isArray(images)) &&
          images.map((image, index) => (
            <div className="swiper-slide home-slider-wrapper-item" key={index}>
              <div class="home-slider-wrapper-item-image">
                <img
                  src={image.url}
                  alt={image.alt}
                  className="gallery-image"
                />
              </div>
            </div>
          ))}
      </div>
      <div class="swiper-pagination home-slider-pagination"></div>
    </div>
  );
}
