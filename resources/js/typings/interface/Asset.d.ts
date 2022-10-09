declare interface Asset{
    name: string,
    type: "icon" | "illustration",
    slug: string,
    preview_86? : "string",
    preview_320? : "string",
    preview_url_w128? : "string",
    preview_url_w512? : "string",
    url_show? : "string",
}