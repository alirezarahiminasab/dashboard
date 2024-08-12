import { __ } from "@wordpress/i18n";
import { useState, useEffect } from "@wordpress/element";
import { useBlockProps } from "@wordpress/block-editor";
import { SelectControl } from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const [tags, setTags] = useState([]);
  const { selectedTags } = attributes;
  const blockProps = useBlockProps();

  useEffect(() => {
    // Fetch all tags from WordPress REST API
    apiFetch({ path: "/wp/v2/tags" }).then((response) => {
      setTags(response);
    });
  }, []);

  const onChangeTags = (newTags) => {
    setAttributes({ selectedTags: newTags });
  };

  return (
    <div {...blockProps}>
      <SelectControl
        label="Select Tags"
        multiple
        value={selectedTags}
        options={tags.map((tag) => ({ label: tag.name, value: tag.id }))}
        onChange={onChangeTags}
      />
    </div>
  );
}
