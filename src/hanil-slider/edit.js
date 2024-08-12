import { __ } from "@wordpress/i18n";
import { useBlockProps, MediaUpload } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { images } = attributes;
  const blockProps = useBlockProps();

  const onSelectImages = (newImages) => {
    setAttributes({ images: newImages });
  };

  return (
    <div {...blockProps}>
      <div className="gallery-thumbnails">
        {(images || Array.isArray(images)) &&
          images.map((image) => (
            <img
              key={image.id}
              src={image.url}
              alt={image.alt}
              data-mfp-src={image.url}
            />
          ))}
      </div>
      <MediaUpload
        onSelect={onSelectImages}
        allowedTypes={["image"]}
        multiple
        gallery
        value={
          (images || Array.isArray(images)) && images.map((image) => image.id)
        }
        render={({ open }) =>
          (images || Array.isArray(images)) && (
            <Button onClick={open}>{__("Select Images")}</Button>
          )
        }
      />
    </div>
  );
}
