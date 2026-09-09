---
name: cover-creator
description: Generate and store a branded 16:9 WebP cover image for a blog entry in this repository. Use when asked to create a blog cover from a scene description.
---

# Blog cover creator

Create one SFMLM-branded blog cover from the user's scene description. The description is required; ask for it only when it was not provided.

## Generate the cover

Resolve every bundled resource relative to the directory containing this loaded `SKILL.md`, never relative to the session working directory. Canonicalize the resulting path before passing it to a tool.

1. Read [references/brand-image-prompt.md](references/brand-image-prompt.md) completely.
2. Replace `<insert_scene_here>` with the user's scene description verbatim. Do not retain the placeholder or substitute a generic scene.
3. Resolve [assets/favicon.png](assets/favicon.png) from this skill directory to an absolute local path and verify that it is a readable file. If it is missing or unreadable, stop and report the resolved path; do not generate an unbranded image or ask the user to locate the bundled asset.
4. Generate one new image with the built-in image-generation tool. Pass the verified absolute favicon path through `referenced_image_paths` as the sole reference image and label it as the SFMLM favicon/brand element, not as an edit target. Do not substitute `logo.png`, `public/favicon.svg`, another asset, or a prior conversation image.
5. Inspect the result before accepting it. It must:
   - depict the requested scene clearly;
   - use the dark navy, teal/cyan, futuristic corporate-technology aesthetic from the template;
   - include the referenced favicon as an important, naturally integrated element without visible deformation or redesign;
   - contain no text except text already present in the favicon, and no random letters or numbers.
6. If any acceptance check fails, make one targeted retry that restates only the failed requirement and all logo/text invariants. Inspect the retry. If it still fails, do not store or index it; report the failed checks.

## Store the finished cover

- The sole delivered image belongs in `public/images/blog/` and must be a 1672×941 `.webp` file. Never leave a `.png`, `.jpg`, `.jpeg`, or other non-WebP image in that folder.
- Use `public/images/blog/0-image_index.txt` as the source of truth for numbering. Read its existing canonical `.webp` entries, take the highest three-digit numeric prefix, and use the next integer, zero-padded to three digits. For example, after `001-adu-planning.webp`, use `002-...`. Do not reuse numbers unless the user explicitly asks to replace an existing indexed cover.
- Create a concise, descriptive, lowercase, hyphen-separated slug of two or three words from the scene or blog topic. The filename must be `NNN-slug.webp`, such as `035-network-growth.webp`.
- The brand prompt requests a 1920×1080 16:9 composition. Export the accepted artifact as WebP and normalize it to exactly 1672×941 px without stretching; use a centered crop only when the source aspect ratio differs.
- Keep temporary source artifacts outside `public/images/blog/`. Remove them after successful conversion when they were created solely for this workflow.
- Verify that the stored image is WebP, exactly 1672×941 px, and no larger than 220 MB (230,686,720 bytes).
- Add the final filename, including `.webp`, as a new line in `public/images/blog/0-image_index.txt` only after the file is successfully written and verified. Do not add derivative-size filenames or duplicate entries.

Report the final repository-relative image path, the final prompt, and that the built-in image-generation tool was used.
