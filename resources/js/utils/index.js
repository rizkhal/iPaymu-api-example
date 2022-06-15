export const formatNumber = (price) => {
  if (typeof price == "undefined" || price == null || price == 0) return 0;
  
  return Intl.NumberFormat("id-ID").format(price);
};
