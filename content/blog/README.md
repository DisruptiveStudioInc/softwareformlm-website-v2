# Blog authoring guide

Blog entries live in `content/blog/en/{slug}.md` and `content/blog/es/{slug}.md`. The filename must match the `url` field. Covers live in `public/images/blog/` and must be committed with the post.

Required front matter fields are `name`, `cover`, `cover_alt`, `url`, `seo_description`, `language`, `date`, `published`, and `categories`. The `translation`, `updated`, and `author` fields are optional.

- Use a canonical category key declared in `categories.yaml`.
- Use lowercase, hyphenated slugs.
- Set `published: true` when an article is ready; drafts and future-dated posts stay hidden.
- A missing translation is allowed and sends the language selector to the other language's blog index.
- Raw HTML and unsafe URL schemes are removed. Use Markdown for headings, emphasis, links, images, lists, quotes, code, and tables.
- Markdown headings require a space after `#`.
