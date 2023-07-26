import en from './../lang/en.json'
import mm from './../lang/mm.json'
import { store } from "./../Store/index";

export const defaultLocale = store.getters.languageCode;

export const languages = {
    en: en,
    mm: mm,
}
