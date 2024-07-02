import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { selectedTags } = attributes;

  const blockProps = useBlockProps.save({ className: "home-tags" });

  return (
    <div
      {...blockProps}
      data-slides={selectedTags.length > 3 ? 3 : 1}
      data-space="12"
      data-free="true"
      data-speed="2000"
      data-loop="true"
      data-autoplay="0.1"
    >
      <div className="swiper-wrapper home-tags-wrapper">
        {(images || Array.isArray(images)) &&
          images.map((image, index) => (
            <div className="swiper-slide home-tags-wrapper-item" key={index}>
              <div class="home-slider-wrapper-item-image">
                <a href=""></a>
              </div>
            </div>
          ))}
      </div>
      <div class="swiper-pagination home-slider-pagination"></div>
    </div>
  );
}
